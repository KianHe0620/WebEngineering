<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Side and Top Navigation</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script> 
    <style>
        input[type="text"]{
            width: 30%;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <!-- Sidebar content -->
    </div>

    <div class="topnav">
        <!-- Top navigation content -->
    </div>

    <div class="content">
        <h2>New Parking Area</h2>
        <p>New parking information:</p>
        <div id="section1">
        <?php
        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addparking'])){
            // Safely access the 'Parking_area' key
            $Parking_area = isset($_POST['Parking_area']) ? $_POST['Parking_area'] : 'Not specified';

            // Safely access the 'Parking_number' key
            $Parking_number = isset($_POST['Parking_number']) ? $_POST['Parking_number'] : 'Not specified';

            // Output the values
            echo "Area: " . htmlspecialchars($Parking_area) . "<br>";
            echo "Parking Number: " . htmlspecialchars($Parking_number) . "<br>" . "<br>";
        } else {
            // Handle the case where the form was not submitted
            echo "No data submitted.";
        }
        ?>
            
        </div>
        <div class="row justify-content-left">
            <div class="col-auto border mb-5" id="qrcode"></div>
        </div>
    </div>
    <script src="qrcode.min.js"></script>
    <script>
        var qrcode = new QRCode("qrcode");
        var parking_id = <?php echo $_GET['parking_id'];?>;
        qrcode.makeCode("http://localhost/WebEngineering/ManageParking/viewparking.php?parking_id=" + parking_id);
    </script>
        <button type="submit" class="btn btn-primary" onclick="document.location='addparking.php'">Back</button>
        </div>
    </div>
</body>
</html>
