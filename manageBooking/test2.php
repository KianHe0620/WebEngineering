<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bars</title>
    <link rel="stylesheet" href="../css/styles.css"> 
</head>
<body>

<div class="top">
    <div class="logo">
    <img src="../image/umpsa_logo.png">
    </div>
    <div class="topnav">
        <form action="" method="">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><img src="../image/search.png" height="20px" width="20px"></button>
        </form>
        <a href="">Home</a>
        <a href="">About</a>
        <a href="">FAQ</a>
        <a href="">Announcement</a>
        <a href="">Contact</a>
        <div class="welcome">Hi, ...</div>
    </div>
</div>
<div class="sidebar">
    <table>
        <tr>
            <th>User Profile</th>
        </tr>
        <tr>
            <td><a href="">Content</a></td>
        </tr>
        <tr>
            <td><a href="">Content</a><td>
        </tr>
        <tr>
            <th>Parking Area</th>
        </tr>
        <tr>
            <td><a href="">Content</a></td>
        </tr>
        <tr>
            <td><a href="">Content</a><td>
        </tr>
        <tr>
            <th>Parking Booking</th>
        </tr>
            <td><a href="">Content</a></td>
        </tr>
        <tr>
            <td><a href="">Content</a><td>
        </tr>
        <tr>
            <th>Traffic Summon</th>
        </tr>
        <tr>
            <td><a href="">Content</a></td>
        </tr>
        <tr>
            <td><a href="">Content</a><td>
        </tr>
    </table>
    <div class="logout">
        <a href="">Log Out</a>
    </div>
</div>

<div class="main">
<h1>Student Parking Booking</h1>
    <div class="filter"><img src="../image/filter.png" alt="filter icon" width="30px" height="30px">Filter</div>
    <br><br>
    <table>
        <tr>
            <th><label for="bookingDate">Date:</label></th>
            <th><input type="date" name="bookingDate"></th>
        </tr>
        <tr>
            <th><label for="bookingTime">Time:</label></th>
            <th><select name="bookingTime" id="bookingTime"></th>
        </tr>
    </table>
</div>

</body>
</html>


