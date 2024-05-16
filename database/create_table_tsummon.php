<?php
    try {
        require "conn_db.php";
        $sql = "CREATE TABLE TrafficSummon(
            TSummon_id VARCHAR(10) PRIMARY KEY,
            TSummon_date DATE,
            Violation_type VARCHAR(30),
            Demerit_point INT,
            Enforcement_type VARCHAR(100),
            UKStaff_id VARCHAR(10) NOT NULL,
            Student_id VARCHAR(10) NOT NULL,
            FOREIGN KEY(Student_id) REFERENCES Student(Student_id),
            FOREIGN KEY(UKStaff_id) REFERENCES UnitKeselamatanStaff(UKStaff_id)
            )";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>