<?php

$pathHelpers = "helpers.php";

require_once($pathHelpers);

class Student {
    const path = "../assets/data/students.json";

    static function getStudentInfo($name) {
        $newStudent = true;

        $allStudents = Helpers::getJSONData(Student::path);

        foreach ($allStudents as $key => $student) {
            if ($student["name"] == $name) {
                if ($_POST && $_POST["action"] == "submitNewArrival") $allStudents[$key]["arrivals"] += 1;
                $newStudent = false;
            }
        }
        if ($newStudent) array_push($allStudents, ["name" => $name, "arrivals" => 0]);
        
        Helpers::addFileData(Student::path, json_encode($allStudents, JSON_PRETTY_PRINT));
    }

    static function getStudent($name) {
        $allStudents = Helpers::getJSONData(Student::path);

        foreach ($allStudents as $student) {
            if ($student["name"] == $name) return $student;
        }
    }
}

?>