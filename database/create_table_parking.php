<?php
    try {
        require "conn_db.php";
        $sql = "CREATE TABLE Parking(
            Parking_number VARCHAR(10) NOT NULL PRIMARY KEY,
            Parking_area VARCHAR(10),
            Parking_status VARCHAR(9)
            )";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>