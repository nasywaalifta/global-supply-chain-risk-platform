<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SupplyRisk Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body{
            margin:0;
            font-family:Arial,Helvetica,sans-serif;
            background:linear-gradient(135deg,#0f172a,#1e3a8a,#2563eb);
        }

        .login-wrapper{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .login-card{
            width:100%;
            max-width:450px;
            background:#fff;
            border-radius:18px;
            padding:35px;
            box-shadow:0 15px 35px rgba(0,0,0,.2);
        }

        .logo{
            text-align:center;
            margin-bottom:25px;
        }

        .logo h2{
            margin:0;
            color:#1e40af;
            font-weight:bold;
        }

        .logo p{
            margin-top:8px;
            color:#666;
            font-size:14px;
        }

        footer{
            text-align:center;
            color:white;
            margin-top:20px;
            font-size:13px;
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <div>

        <div class="login-card">

            <div class="logo">
                <h2>🌍 SupplyRisk</h2>
                <p>Global Supply Chain Risk Intelligence Platform</p>
            </div>

            {{ $slot }}

        </div>

        <footer>
            © 2026 SupplyRisk
        </footer>

    </div>

</div>

</body>
</html>