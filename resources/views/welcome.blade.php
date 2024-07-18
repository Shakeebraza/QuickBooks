<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .header {
            width: 100%;
            padding: 20px;
            background-color: #007bff;
            color: white;
            text-align: right;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin-left: 15px;
        }
        .header a:hover {
            text-decoration: underline;
        }
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .content h1 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
        }
        .container {
            width: 80%;
            margin-top: 20px;
        }
        .alert {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .card {
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            font-size: 18px;
        }
        .card-body {
            padding: 15px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- <a href="{{ url('/login') }}">Login</a>
        <a href="{{ url('/signup') }}">Signup</a> -->

        <a href="{{ route('quickbooks.connect') }}" class="btn btn-primary">Connect to QuickBooks</a>
    </div>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('QuickBooks Integration Details') }}</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Key</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (session('accessToken'))
                                    <tr>
                                        <td><strong>Access Token</strong></td>
                                        <td>{{ session('accessToken') }}</td>
                                    </tr>
                                @endif

                                @if (session('refreshToken'))
                                    <tr>
                                        <td><strong>Refresh Token</strong></td>
                                        <td>{{ session('refreshToken') }}</td>
                                    </tr>
                                @endif

                                @if (session('realmId'))
                                    <tr>
                                        <td><strong>Realm ID</strong></td>
                                        <td>{{ session('realmId') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <h1>Welcome to the Home Page</h1>
        <a href="{{ route('quickbooks.connect') }}" class="btn btn-primary">Connect to QuickBooks</a>
    </div>
</body>
</html>
