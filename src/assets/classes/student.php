<?php

$pathHelpers = "../assets/classes/helpers.php";

require_once($pathHelpers);

class Student {
    const path = "../assets/data/students.json";

    static function getStudentInfo($name) {
        $newStudent = true;

        $allStudents = Helpers::getJSONData(Student::path);

        for ($i = 0; $i < count($allStudents); $i++) {
            if ($allStudents[$i]["name"] == $name) {
                if ($_POST && $_POST["action"] == "submitNewArrival") $allStudents[$i]["arrivals"] += 1;
                $newStudent = false;
            }
        }
        if ($newStudent) array_push($allStudents, ["name" => $name, "arrivals" => 0]);
        
        Helpers::addFileData(Student::path, json_encode($allStudents, JSON_PRETTY_PRINT));
    }

    static function getStudent($name) {
        $allStudents = Helpers::getJSONData(Student::path);

        for ($i = 0; $i < count($allStudents); $i++) {
            if ($allStudents[$i]["name"] == $name) return $allStudents[$i];
        }
    }
}

?>