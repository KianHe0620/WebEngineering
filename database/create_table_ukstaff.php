<?php
    try {
        require "conn_db.php";
        $sql = "CREATE TABLE UnitKeselamatanStaff(
            UKStaff_id VARCHAR(10) NOT NULL PRIMARY KEY,
            UKStaff_name VARCHAR(30),
            UKStaff_IC VARCHAR(14),
            UKStaff_phoneNum VARCHAR(12),
            UKStaff_email VARCHAR(30),
            UKStaff_password VARCHAR(30)
            )";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>