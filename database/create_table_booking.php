<?php
    try {
        require "conn_db.php";
        $sql = "CREATE TABLE Booking(
            Booking_id VARCHAR(10) NOT NULL PRIMARY KEY,
            Start_time TIME,
            End_time TIME,
            Booking_date DATE,
            Parking_number VARCHAR(10) NOT NULL,
            Vehicle_platenum VARCHAR(10) NOT NULL,
            Student_id VARCHAR(10) NOT NULL,
            FOREIGN KEY(Parking_number) REFERENCES Parking(Parking_number),
            FOREIGN KEY(Vehicle_platenum) REFERENCES Vehicle(Vehicle_platenum),
            FOREIGN KEY(Student_id) REFERENCES Student(Student_id)
        )";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>
