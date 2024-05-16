<?php
    try {
        require "conn_db.php";
        $sql = "CREATE TABLE Student(
            Student_id VARCHAR(10) NOT NULL PRIMARY KEY,
            Student_name VARCHAR(30),
            Student_IC VARCHAR(14),
            Student_citizenship VARCHAR(30),
            Student_phoneNum VARCHAR(12),
            Student_email VARCHAR(30),
            Student_address VARCHAR(50),
            Student_password VARCHAR(30)
            )";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>