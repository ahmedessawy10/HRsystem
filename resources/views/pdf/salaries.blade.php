<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salaries Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 10px;
            background-color: #f9f9f9;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }

        header div {
            max-width: 60%;
        }

        header img {
            max-height: 60px;
        }

        h1,
        h2 {
            margin: 10px 0;
            color: #333;
        }

        table {
            width: 99%;
            margin: 0px auto;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .text-bold {
            font-weight: bold;
        }


        table td {
            font-size: 12px;
        }

        table th {
            font-size: 13px;
        }

        /* تحسين الطباعة */
        @media print {
            body {
                background: none;
                font-size: 12px;
            }

            header {
                background-color: white;
                color: black;
                border-bottom: 2px solid #000;
            }

            table {
                box-shadow: none;

            }

            table td {
                font-size: 12px;
            }

            table th {
                font-size: 13px;
            }

            h1,
            h2 {
                color: black;
            }
        }
    </style>
</head>

<body>

    <header>
        <div>
            <h1>Company: {{ $company->name }}</h1>
            <p><strong>Address:</strong> {{ $company->address }}</p>
            <p><strong>Phone:</strong> {{ $company->phone }}</p>
            <p><strong>Email:</strong> {{ $company->email }}</p>
        </div>
        <img src="{{ asset('uploads/'.$appSetting->logo) }}" alt="Company Logo">
        <h3>Print Date: {{ now() }}</h3>
    </header>

    <h1>Salary Report</h1>
    <h2>Year: {{ $salary->year }}</h2>
    <h2>Month: {{ $salary->month }}</h2>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Salary (EGP)</th>
                <th>Attendance (Days)</th>
                <th>Absence (Days)</th>
                <th>Late (Hours)</th>
                <th>Extra (Hours)</th>
                <th>Late Cost (EGP)</th>
                <th>Extra Cost (EGP)</th>
                <th>Net Salary (EGP)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $salary->user->fullname }}</td>
                <td>{{ $salary->user->department?->name ?? 'N/A' }}</td>
                <td>{{ number_format($salary->salary, 2) ?? '0.00' }}</td>
                <td>{{ $salary->attendances_count ?? 0 }}</td>
                <td>{{ $salary->absents_count ?? 0 }}</td>
                <td>{{ $salary->late_hours ?? 0 }}</td>
                <td>{{ $salary->extra_hours ?? 0 }}</td>
                <td>{{ number_format($salary->late_cost, 2) ?? '0.00' }}</td>
                <td>{{ number_format($salary->extra_cost, 2) ?? '0.00' }}</td>
                <td class="text-bold text-right">{{ number_format($salary->net_salary, 2) }} EGP</td>
            </tr>
        </tbody>
    </table>

</body>

</html>