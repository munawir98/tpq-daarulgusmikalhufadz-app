<h2>Activity Log Report</h2>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>User</th>
            <th>Event</th>
            <th>Description</th>
            <th>Model</th>
            <th>Waktu</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $log)
        <tr>
            <td>{{ $log->causer->name ?? '-' }}</td>
            <td>{{ $log->event }}</td>
            <td>{{ $log->description }}</td>
            <td>{{ class_basename($log->subject_type) }}</td>
            <td>{{ $log->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
