<?php
    try {
        require "conn_db.php";
        $sql = "CREATE TABLE Vehicle(
            Vehicle_platenum VARCHAR(10) NOT NULL PRIMARY KEY,
            Vehicle_type VARCHAR(30),
            Student_id VARCHAR(10) NOT NULL,
            FOREIGN KEY(Student_id) REFERENCES Student(Student_id)
            )";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>