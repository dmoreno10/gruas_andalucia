<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile PDF</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #444;
            margin: 0;
            padding: 0;
            background-color: #eef1f5;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 28px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .profile-info {
            width: 100%;
            margin-bottom: 20px;
        }
        .profile-info p {
            font-size: 16px;
            color: #34495e;
            margin-bottom: 8px;
            line-height: 1.5;
        }
        .profile-info p span {
            font-weight: bold;
            color: #3498db;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 30px;
        }
        .profile-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .profile-table th, .profile-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .profile-table th {
            background-color: #3498db;
            color: #fff;
            font-weight: bold;
        }
        .profile-table tr:hover {
            background-color: #f1f1f1;
        }
        .profile-picture {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .profile-picture img {
            border-radius: 50%;
            border: 3px solid #3498db;
            width: 120px;
            height: 120px;
            object-fit: cover;
        }
        .highlight {
            background-color: #e8f6f3;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">


        <table class="profile-table">
            <tr>
                <th>Name</th>
                <td>{{ $employee->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $employee->email }}</td>
            </tr>
            <tr>
                <th>Position</th>
                <td>{{ $employee->position }}</td>
            </tr>
            <tr>
                <th>Department</th>
                <td>{{ $employee->department }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $employee->created_at->format('d/m/Y') }}</td>
            </tr>
        </table>

        <div class="highlight">
            <p>Additional Information: You can add more details about the employee here, such as their achievements, roles, etc.</p>
        </div>

        <p class="footer">This document was generated on {{ now()->format('d/m/Y') }}</p>
    </div>
</body>
</html>
