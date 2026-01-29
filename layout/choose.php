
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
/* ===== RESET ===== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    background:#f8f9fa;
    padding-left:260px;
}

/* ===== SIDEBAR ===== */
.sidebar{
    position:fixed;
    top:0; left:0;
    width:260px;
    height:100vh;
    background:linear-gradient(180deg,#ff4d6d,#ff758f);
    color:#fff;
    box-shadow:4px 0 15px rgba(0,0,0,.1);
    transition:.3s;
    z-index:1000;
}

.sidebar.compact{
    width:70px;
}

/* ===== LOGO ===== */
.logo{
    display:flex;
    align-items:center;
    gap:10px;
    padding:20px;
    font-size:22px;
    font-weight:700;
    cursor:pointer;
    position:relative;
}

.logo span:last-child{
    white-space:nowrap;
}

.sidebar.compact .logo span:last-child{
    display:none;
}

/* divider bawah logo */
.logo::after{
    content:'';
    position:absolute;
    left:20px;
    right:20px;
    bottom:-8px;
    height:1px;
    background:rgba(255,255,255,.35);
}

/* ===== MENU ===== */
.menu{
    padding:30px 15px 15px;
}

.menu-item{
    display:flex;
    align-items:center;
    gap:15px;
    padding:14px 12px;
    margin-bottom:8px;
    border-radius:10px;
    color:#fff;
    text-decoration:none;
    transition:.25s ease;
    position:relative;
}

.menu-item .icon{
    font-size:20px;
    min-width:20px;
}

.menu-item span{
    white-space:nowrap;
}

/* hover */
.menu-item:hover{
    background:rgba(255,255,255,.15);
}

/* active */
.menu-item.active{
    background:rgba(255,255,255,.25);
}

.menu-item.active::before{
    content:'';
    position:absolute;
    left:0;
    top:50%;
    transform:translateY(-50%);
    width:4px;
    height:60%;
    border-radius:0 4px 4px 0;
}

/* compact menu */
.sidebar.compact .menu-item{
    justify-content:center;
    padding:14px 0;
}

.sidebar.compact .menu-item span:not(.icon){
    display:none;
}

.sidebar.compact .menu-item.active::before{
    display:none;
}

/* ===== MOBILE ===== */
@media(max-width:768px){
    body{
        padding-left:0;
        padding-bottom:75px;
    }

    .sidebar{
        top:auto;
        bottom:0;
        width:100%;
        height:75px;
        display:flex;
        justify-content:space-around;
        align-items:center;
        
    }

    .logo{
        display:none;
    }

    .menu{
        display:flex;
        width:100%;
        padding:0;
        justify-content:space-around;
    }

    .menu-item{
        flex-direction:column;
        gap:4px;
        margin:0;
        padding:8px;
        font-size:10px;
    }

    .menu-item.active::before{
        display:none;
    }
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">

    <!-- LOGO -->
    <div class="logo" id="toggleBtn">
        <i class="fa-solid fa-kitchen-set"></i>
        <span>KEBAB PINK</span>
    </div>

    <!-- MENU -->
    <div class="menu">
        <a href="/kebab-app/dashboard/index.php" class="menu-item">
            <span class="icon"><i class="fa-solid fa-house"></i></span>
            <span>Dashboard</span>
        </a>

        <a href="/kebab-app/masterdata/bahan/index.php" class="menu-item">
            <span class="icon"><i class="fa-solid fa-carrot"></i></span>
            <span>Bahan</span>
        </a>

        <a href="/kebab-app/masterdata/menu/index.php" class="menu-item">
            <span class="icon"><i class="fa-solid fa-utensils"></i></span>
            <span>Menu</span>
        </a>

        <a href="/kebab-app/masterdata/penjualan/index.php" class="menu-item">
            <span class="icon"><i class="fa-solid fa-cart-shopping"></i></span>
            <span>Penjualan</span>
        </a>

        <a href="/kebab-app/auth/logout.php" class="menu-item">
            <span class="icon"><i class="fa-solid fa-door-closed"></i></span>
            <span>Logout</span>
        </a>
    </div>
</div>

<!-- SCRIPT -->
<script>
const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('toggleBtn');

/* toggle compact */
toggleBtn.onclick = () => {
    sidebar.classList.toggle('compact');
    localStorage.setItem(
        'sidebarCompact',
        sidebar.classList.contains('compact')
    );
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

/* active menu */
document.querySelectorAll('.menu-item').forEach(link=>{
    if(location.pathname === new URL(link.href).pathname){
        link.classList.add('active');
    }
});

window.addEventListener('resize', setPadding);
</script>
