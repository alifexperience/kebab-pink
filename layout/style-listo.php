<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f8f9fa;
    color: #333;
}

.content {
    padding: 25px;
    max-width: 1400px;
    margin: auto;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eaeaea;
}

.header h2 {
    color: #ff4d6d;
    font-size: 28px;
    font-weight: 700;
}

.btn-add {
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    background: linear-gradient(135deg, #ff4d6d, #ff758f);
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: .3s;
    box-shadow: 0 4px 12px rgba(255,77,109,.3);
}

.btn-add:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(255,77,109,.4);
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 14px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: .2s;
}

.btn i { margin-right: 5px; font-size: 12px; }

.btn-edit {
    background: rgba(33,150,243,.1);
    color: #2196f3;
    border: 1px solid rgba(33,150,243,.3);
}

.btn-delete {
    background: rgba(244,67,54,.1);
    color: #f44336;
    border: 1px solid rgba(244,67,54,.3);
}

.btn-view {
    background: #e3f2fd;
    color: #1565c0;
    border: 1px solid rgba(22, 158, 248, 0.75);
}

.btn-print {
    background: #e8f5e9;
    color: #2e7d32;
    border: 1px solid rgba(32, 255, 99, 0.6);
}

.summary-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.summary-card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
    display: flex;
    gap: 15px;
    transition: .3s;
}

.summary-card:hover { transform: translateY(-5px); }

.summary-icon {
    width: 55px;
    height: 55px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.summary-icon.total { background: rgba(255,77,109,.15); color: #ff4d6d; }
.summary-icon.low { background: rgba(244,67,54,.15); color: #f44336; }

.total { border-left: 5px solid #ff4d6d; }
.today { border-left: 5px solid #4caf50; }
.transactions { border-left: 5px solid #2196f3; }
.average { border-left: 5px solid #9c27b0; }

/* Versi search container dari style lama */
.search-filter-container{
    display:flex;
    justify-content:row;
    align-items:center;
    gap: 10px;
}
.search-container {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    background: #fff;
    border-radius: 10px;
    padding: 8px 14px;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
    height: 45px;
}

.search-container input {
    border: none;
    outline: none;
    font-size: 14px;
    width: 200px;
}

.filter-select{
    border:none;
    margin-bottom:20px;
    background: #fff;
    border-radius: 10px;
    padding: 8px 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
    height: 45px;
}

.table-container {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,.08);
    overflow: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: linear-gradient(135deg, #ff4d6d, #ff758f);
    color: #fff;
}

th, td {
    padding: 15px;
    font-size: 14px;
}

tbody tr {
    border-bottom: 1px solid #f0f0f0;
    transition: .2s;
}

tbody tr:hover {
    background: rgba(255,77,109,.05);
}

   STATUS / BADGE
.stock-status,
.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.stock-high,
.status-paid {
    background: #e8f5e9;
    color: #2e7d32;
}

.stock-medium,
.status-pending {
    background: #fff3e0;
    color: #ef6c00;
}

.stock-low,
.status-cancelled {
    background: #ffebee;
    color: #c62828;
}

.action-cell {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.pagination {
    margin-top: 25px;
    text-align: center;
}

.pagination a,
.pagination span {
    padding: 8px 14px;
    border-radius: 6px;
    background: #fff;
    border: 1px solid #ddd;
    font-weight: 600;
}

.pagination .active {
    background: #ff4d6d;
    color: #fff;
    border-color: #ff4d6d;
}

@media (max-width: 768px) {
    .header { flex-direction: column; align-items: flex-start; gap: 15px; }
    .search-box, .filter-select { width: 100%; }
    table { min-width: 700px; }
}
</style>
