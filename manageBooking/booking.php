<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Side and Top Navigation</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
    <script defer src="../js/filter.js"></script> 
</head>
<body>

    <div class="sidebar">
        <table>
            <tr>
                <th>User Profile</th>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <th>Parking Area</th>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <th>Parking Booking</th>
            </tr>
            <tr>
                <td><a href="booking.php">Booking</a></td>
            </tr>
            <tr>
                <td><a href="view.php">Content</a></td>
            </tr>
            <tr>
                <th>Traffic Summon</th>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <th><a href="">Log Out</a></th>
            </tr>
        </table>
        <!-- <div class="logout">
            <a href="">Log Out</a>
        </div> -->
    </div>

    <div class="topnav">
        <div id="menuBtn">&#9776;</div>
        <div class="logo">
            <img src="../image/umpsa_logo.png" alt="Logo" width="150" height="50">
        </div>
        <div class="search-bar">
            <form action="" method="">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><img src="../image/search.png" height="20px" width="20px"></button>
            </form>
        </div>
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#services">Services</a>
        <a href="#contact">Contact</a>
    </div>

    <div class="content">
    <h2>Student Parking Booking</h2><br>
        <!-- <div class="filter"><img src="../image/filter.png" alt="filter icon" width="30px" height="30px">Filter</div>
        <br><br>
        <table>
            <tr>
                <th><label for="bookingDate">Date:</label></th>
                <th><input type="date" name="bookingDate"></th>
            </tr>
            <tr>
                <th><label for="bookingTime">Time:</label></th>
                <th><select name="bookingTime" id="bookingTime"></th>
        </table> -->
        <div class="container mt-3"> 
        <h2>Bootstrap filter for table</h2> 
        <input type="text" 
               class="form-control" 
               placeholder="Search Here"
               id="txtInputTable"> 
        <br> 
        <table class="table table-bordered"> 
            <thead> 
                <tr> 
                    <th>Id</th> 
                    <th>Name</th> 
                    <th>Email</th> 
                    <th>Phone No.</th> 
                </tr> 
            </thead> 
            <tbody id="tableDetails"> 
                <tr> 
                    <td>101</td> 
                    <td>Ram</td> 
                    <td>ram@abc.com</td> 
                    <td>8541236548</td> 
                </tr> 
                <tr> 
                    <td>102</td> 
                    <td>Manish</td> 
                    <td>manish@abc.com</td> 
                    <td>2354678951</td> 
                </tr> 
                <tr> 
                    <td>104</td> 
                    <td>Rahul</td> 
                    <td>rahul@abc.com</td> 
                    <td>5789632569</td> 
                </tr> 
                <tr> 
                    <td>105</td> 
                    <td>Kirti</td> 
                    <td>kirti@abc.com</td> 
                    <td>5846325968</td> 
                </tr> 
            </tbody> 
        </table> 
    </div> 
    </div>
</body>
</html>
