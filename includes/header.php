<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySchedule - Jadwal Kuliah</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background: #E2C892;
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(180deg, #845512 0%, #a97124 100%);
            min-height: 100vh;
            color: white;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
            padding: 20px;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            padding-bottom: 80px;
        }

        .nav-item {
            padding: 12px 16px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .nav-item.active {
            background: white;
            color: #845512;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            color: white;
        }

        .user-info {
            background: rgba(255,255,255,0.1);
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .footer {
            background-color: #8B5E34;
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 14px;
            position: fixed;
            bottom: 0;
            left: 250px;
            width: calc(100% - 250px);
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
            z-index: 999;
        }

        .page-section {
            display: none;
        }

        .page-section.active {
            display: block;
        }

        .search-box {
            position: relative;
            margin-bottom: 30px;
        }

        .search-box input {
            border-radius: 50px;
            padding: 15px 50px 15px 20px;
            border: 2px solid #845512;
            font-size: 16px;
        }

        .search-box .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #845512;
            font-size: 20px;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .calendar-day {
            min-height: 120px;
            padding: 8px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
        }

        .calendar-day:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .calendar-day.has-schedule {
            background: #E2C892;
            border: 2px solid #845512;
        }

        .schedule-indicator {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        .day-number {
            font-weight: bold;
            font-size: 14px;
        }

        .calendar-event {
            background: #845512;
            color: white;
            padding: 4px 6px;
            border-radius: 4px;
            font-size: 11px;
            margin-bottom: 2px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .calendar-event:hover {
            background: #a97124;
            transform: scale(1.05);
        }

        .more-events {
            background: #ffbe5c;
            color: #333;
            padding: 3px;
            border-radius: 4px;
            font-size: 10px;
            text-align: center;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }

        .more-events:hover {
            background: #ffa500;
            transform: scale(1.05);
        }

        .logout-btn {
            margin-top: auto;
            padding: 12px 14px;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            border: none;
            background: #dc3545;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .logout-btn:hover {
            box-shadow: 0 0 20px rgba(220, 53, 69, 0.5);
            transform: scale(1.05);
        }

        @keyframes popIn {
            0% { transform: scale(0.7) translateY(20px); opacity: 0; }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); opacity: 1; }
        }

        .modal.show .modal-dialog {
            animation: popIn 0.3s ease-out;
        }

        .highlight {
            background-color: #ffeb3b;
            font-weight: 600;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                min-height: auto;
                position: fixed;
                bottom: 0;
                top: auto;
                padding: 10px;
                display: flex;
                justify-content: space-around;
                z-index: 1000;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
                padding-bottom: 100px;
            }

            .logo, .logout-btn, .user-info {
                display: none;
            }

            .nav-item span {
                display: none;
            }

            .footer {
                left: 0;
                width: 100%;
                bottom: 60px;
            }
        }
    </style>
</head>
<body>