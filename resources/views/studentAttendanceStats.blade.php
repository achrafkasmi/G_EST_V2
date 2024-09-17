<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Stats</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

    <h2>Attendance Stats Report</h2>
    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Apogee</th>
                <th>Total Absent Sessions</th>
                <th>Total Justified Sessions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendanceData as $data)
            <tr>
                <td>{{ $data['student']->nom_fr }} {{ $data['student']->prenom_fr }}</td>
                <td>{{ $data['student']->apogee }}</td>
                <td>{{ $data['absent_sessions'] }}</td>
                <td>{{ $data['justified_sessions'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
