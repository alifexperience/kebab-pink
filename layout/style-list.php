<?php /* STYLE LIST – GABUNGAN */ ?>
<style>

/* ================= RESET & BASE ================= */
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

/* ================= HEADER ================= */
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

/* ================= BUTTON ================= */
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
    cursor: pointer;
    transition: .2s;
    text-decoration: none;
}

.btn i {
    margin-right: 5px;
    font-size: 12px;
}

.btn-view {
    background: #e3f2fd;
    color: #1565c0;
    border: 1px solid rgba(22,158,248,.7);
}

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

.btn-print {
    background: #e8f5e9;
    color: #2e7d32;
    border: 1px solid rgba(32,255,99,.6);
}

/* ================= SEARCH & FILTER ================= */
.search-filter-container {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.search-container {
    display: flex;
    align-items: center;
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

.filter-select {
    background: #fff;
    border-radius: 10px;
    padding: 8px 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
    border: none;
    height: 45px;
}

/* ================= SUMMARY CARD ================= */
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

.summary-card:hover {
    transform: translateY(-5px);
}

.summary-icon {
    width: 55px;
    height: 55px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.summary-icon.total {
    background: rgba(255,77,109,.15);
    color: #ff4d6d;
}

/* ================= TABLE ================= */
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

/* ================= STATUS / BADGE ================= */
.stock-status,
.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.stock-high { background: #e8f5e9; color: #2e7d32; }
.stock-medium { background: #fff3e0; color: #ef6c00; }
.stock-low { background: #ffebee; color: #c62828; }

/* ================= ACTION ================= */
.action-cell {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

/* ================= PAGINATION ================= */
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

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    table {
        min-width: 700px;
    }

    .search-container,
    .filter-select {
        width: 100%;
    }
}

</style>
