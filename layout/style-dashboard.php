    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
            background: #f8f9fa;
            color: #333
        }

        .content {
            padding: 25px;
            max-width: 1400px;
            margin: auto
        }

        /* ===== HEADER ===== */
        .dashboard-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee
        }

        .dashboard-header h2 {
            color: #ff4d6d;
            font-size: 30px
        }

        .date-display {
            color: #777;
            font-size: 14px
        }

        /* ===== WELCOME ===== */
        .welcome-banner {
            background: linear-gradient(135deg, #ff4d6d, #ff758f);
            color: #fff;
            padding: 25px;
            border-radius: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px
        }

        .welcome-banner i {
            font-size: 60px;
            opacity: .8
        }

        /* ===== STATS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 35px
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 22px;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
            transition: .2s
        }

        .stat-card:hover {
            transform: translateY(-4px)
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 18px
        }

        .sales {
            background: rgba(255, 77, 109, .15);
            color: #ff4d6d
        }

        .today {
            background: rgba(255, 152, 0, .15);
            color: #ff9800
        }

        .menuu {
            background: rgba(33, 150, 243, .15);
            color: #2196f3
        }

        .bahan {
            background: rgba(76, 175, 80, .15);
            color: #4caf50
        }

        .stat-info h3 {
            font-size: 26px
        }

        .stat-info p {
            font-size: 14px;
            color: #666
        }

        /* ===== TABLE ===== */
        .tables-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px
        }

        .table-card {
            background: #fff;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08)
        }

        .table-card h3 {
            margin-bottom: 15px
        }

        .mini-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px
        }

        .mini-table th,
        .mini-table td {
            padding: 10px;
            border-bottom: 1px solid #eee
        }

        .badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600
        }

        .badge.low {
            background: rgba(244, 67, 54, .15);
            color: #d32f2f
        }

        .badge.normal {
            background: rgba(76, 175, 80, .15);
            color: #2e7d32
        }

        .see-all {
            text-align: center;
            margin-top: 12px
        }

        .see-all a {
            color: #ff4d6d;
            font-size: 14px;
            text-decoration: none
        }

        @media(max-width:768px) {
            .tables-container {
                grid-template-columns: 1fr
            }

            .welcome-banner {
                flex-direction: column;
                text-align: center;
                gap: 15px
            }
        }
    </style>