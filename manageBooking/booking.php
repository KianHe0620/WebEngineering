<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href=..bootstrap-4.0.0-dist/css/booss">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
    <body>
    <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
      <li><a href="#">Page 3</a></li>
    </ul>
  </div>
</nav>
        <div class="main">
            <div class="split left">
                <li><a href="">User Profile</a></li>
                <li><a href="">Parking Area</a></li>
                <li><a href="">Parking Booking</a></li>
                <li><a href="">Traffic Summon</a></li>
                <li><a href="">Log Out</a></li>
            </div>
            <div class="split right">
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
        </div>  
    </body>
</html>