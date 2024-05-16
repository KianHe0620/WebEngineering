<?php
    try {
        require "conn_db.php";
        $sql = "CREATE TABLE Administrator (
            Admin_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Admin_name VARCHAR(30) NOT NULL,
            Admin_IC VARCHAR(14) NOT NULL UNIQUE,
            Admin_email VARCHAR(30) NOT NULL UNIQUE,
            Admin_phoneNum VARCHAR(12) NOT NULL UNIQUE,
            Admin_password VARCHAR(30) NOT NULL
        )";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>
