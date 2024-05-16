<?php
    try {
        require "conn_db.php";
        $sql = "CREATE TABLE VehicleRegistration(
            VReg_id VARCHAR(10) NOT NULL PRIMARY KEY,
            VReg_status VARCHAR(10),
            VReg_date DATE,
            VReg_grant VARCHAR(50),
            UKStaff_id VARCHAR(10) NOT NULL,
            Student_id VARCHAR(10) NOT NULL,
            Vehicle_platenum VARCHAR(10) NOT NULL,
            FOREIGN KEY(UKStaff_id) REFERENCES UnitKeselamatanStaff(UKStaff_id),
            FOREIGN KEY(Student_id) REFERENCES Student(Student_id),
            FOREIGN KEY(Vehicle_platenum) REFERENCES Vehicle(Vehicle_platenum)
            )";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>
