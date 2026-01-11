<!DOCTYPE html>
<html>

<head>
    <title>Database Debug</title>
    <style>
        body {
            font-family: monospace;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
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
    </style>
</head>

<body>
    <h1>Database Debug Inspector</h1>
    <p>Database: {{ DB::connection()->getDatabaseName() }}</p>

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
</body>

</html>
