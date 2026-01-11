<!DOCTYPE html>
<html>

<head>
    <title>Database Debug</title>
    <style>
        body {
            font-family: monospace;
            padding: 20px;
            font-size: 14px;
        }

        .section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            background: #fff;
        }

        .status-CONNECTED {
            color: white;
            background: green;
            padding: 5px 10px;
            font-weight: bold;
        }

        .status-FAILED {
            color: white;
            background: red;
            padding: 5px 10px;
            font-weight: bold;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #eee;
        }

        .empty {
            color: red;
            background: #ffebee;
        }

        .ok {
            color: green;
            background: #e8f5e9;
        }

        .error {
            color: red;
            background: yellow;
            padding: 10px;
            border: 1px solid orange;
        }
    </style>
</head>

<body>
    <h1>Database Debug Inspector</h1>

    <div class="section">
        <h3>1. Configuration Check (From defaults or .env)</h3>
        <ul>
            <li><strong>DB_HOST:</strong> {{ $debugInfo['config_db_host'] }}</li>
            <li><strong>DB_PORT:</strong> {{ $debugInfo['config_db_port'] }}</li>
            <li><strong>DB_DATABASE:</strong> {{ $debugInfo['config_db_database'] }}</li>
            <li><strong>DB_USERNAME:</strong> {{ $debugInfo['config_db_username'] }}</li>
        </ul>
    </div>

    <div class="section">
        <h3>2. Connection Attempt</h3>
        <p>Status: <span class="status-{{ $debugInfo['connection_status'] }}">{{ $debugInfo['connection_status']
                }}</span></p>

        @if($debugInfo['connection_status'] == 'CONNECTED')
        <p><strong>Actual Database Name:</strong> {{ $debugInfo['database_name'] }}</p>
        <p><strong>Server Version:</strong> {{ $debugInfo['server_version'] }}</p>
        @else
        <div class="error">
            <strong>Error Message:</strong> <br>
            {{ $debugInfo['error_message'] }}
        </div>
        @endif
    </div>

    @if(!empty($tables))
    <div class="section">
        <h3>3. Table Status</h3>
        <table>
            <thead>
                <tr>
                    <th>Table Name</th>
                    <th>Row Count</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tables as $table)
                <tr class="{{ $table['count'] == 0 ? 'empty' : 'ok' }}">
                    <td>{{ $table['name'] }}</td>
                    <td>{{ $table['count'] }}</td>
                    <td>{{ $table['count'] == 0 ? 'EMPTY' : 'HAS DATA' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @elseif(isset($debugInfo['table_error']))
    <div class="error">Failed to list tables: {{ $debugInfo['table_error'] }}</div>
    @endif
</body>

</html>
