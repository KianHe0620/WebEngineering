<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizontal Availability Timeline</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }
        .booked {
            background-color: #ff9999;
        }
        .available {
            background-color: #99ff99;
        }
    </style>
</head>
<body>
    <h1>Availability Timeline</h1>
    <table>
        <tr>
            <th>8 AM</th>
            <th>9 AM</th>
            <th>10 AM</th>
            <th>11 AM</th>
            <th>12 PM</th>
            <th>1 PM</th>
            <th>2 PM</th>
            <th>3 PM</th>
            <th>4 PM</th>
            <th>5 PM</th>
        </tr>
        <tr>
            <td class="booked">Booked</td>
            <td class="booked">Booked</td>
            <td class="available">Available</td>
            <td class="available">Available</td>
            <td class="available">Available</td>
            <td class="available">Available</td>
            <td class="available">Available</td>
            <td class="available">Available</td>
            <td class="available">Available</td>
            <td class="available">Available</td>
        </tr>
    </table>
</body>
</html>
