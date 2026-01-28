
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    body{
        margin:0;
        padding-left:260px;
        font-family:'Segoe UI',sans-serif;
        background:#f8f9fa;
    }

    /* ===== SIDEBAR ===== */
    .sidebar{
        position:fixed;
        top:0;left:0;
        width:260px;height:100vh;
        background:linear-gradient(180deg,#ff4d6d,#ff758f);
        color:#fff;
        box-shadow:4px 0 15px rgba(0,0,0,.1);
        z-index:1000;
    }
    .sidebar.compact{width:70px}

    /* logo */
    .logo{
        display:flex;
        align-items:center;
        padding:20px 20px 20px 20px;
        font-size:22px;
        font-weight:bold;
        cursor: pointer;
    }
    .logo span:last-child{margin-left:8px}
    .sidebar.compact .logo span:last-child{display:none}

    /* menu */
    .menu{padding:15px}
    .menu-item{
        display:flex;
        align-items:center;
        gap:15px;
        padding:14px 14px 14px 6px;
        margin-bottom:8px;
        border-radius:10px;
        color:#fff;
        text-decoration:none;
        transition:.3s;
    }
    .icon{font-size:20px}
    .sidebar.compact .menu-item span:not(.icon){display:none}

    /* ===== MOBILE ===== */
    @media(max-width:768px){
        body{padding-left:0;padding-bottom:70px}
        .sidebar{
            top:auto;bottom:0;
            width:100%;height:70px;
            display:flex;
            align-items:center;
            justify-content:space-around;
            border-radius:20px 20px 0 0;
        }
        .logo,.toggle-btn,.user-profile{display:none}
        .menu{
            display:flex;
            padding:0;
            width:100%;
            justify-content:space-around;
        }
        .menu-item{
            flex-direction:column;
            gap:4px;
            margin:0;
            padding:8px;
            font-size:10px;
        }
    }
</style>
</head>

<body>

<div class="sidebar" id="sidebar">

    <div class="logo" id="toggleBtn"><i class="fa-solid fa-kitchen-set"></i><span>KEBAB APP</span></div>

    <div class="menu">
        <a href="/kebab-app/dashboard/index.php" class="menu-item">
            <span class="icon"><i class="fa-solid fa-house"></i></span><span>Dashboard</span>
        </a>
        <a href="/kebab-app/masterdata/bahan/index.php" class="menu-item">
            <span class="icon"><i class="fa-solid fa-carrot"></i></span><span>Bahan</span>
        </a>
        <a href="/kebab-app/masterdata/menu/index.php" class="menu-item">
            <span class="icon"><i class="fa-solid fa-utensils"></i></span><span>Menu</span>
        </a>
        <a href="/kebab-app/masterdata/penjualan/index.php" class="menu-item">
            <span class="icon"><i class="fa-solid fa-cart-shopping"></i></span><span>Penjualan</span>
        </a>
        <a href="/kebab-app/auth/logout.php" class="menu-item">
            <span class="icon"><i class="fa-solid fa-door-closed"></i></span><span>Logout</span>
        </a>
    </div>
</div>

<script>
const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('toggleBtn');

/* toggle compact */
toggleBtn.onclick = () => {
    sidebar.classList.toggle('compact');
    localStorage.setItem('sidebarCompact', sidebar.classList.contains('compact'));
    setPadding();
};

/* padding body */
function setPadding(){
    if(window.innerWidth <= 768){
        document.body.style.paddingLeft = '0';
        sidebar.classList.remove('compact');
        return;
    }
    document.body.style.paddingLeft =
        sidebar.classList.contains('compact') ? '70px' : '260px';
}

/* restore state */
if(localStorage.getItem('sidebarCompact') === 'true'){
    sidebar.classList.add('compact');
}
setPadding();

/* active menu by URL */
document.querySelectorAll('.menu-item').forEach(link=>{
    if(location.pathname === new URL(link.href).pathname){
        link.classList.add('active');
    }
});

window.addEventListener('resize', setPadding);
</script>

