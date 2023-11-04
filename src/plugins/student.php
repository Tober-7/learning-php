<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Arrivals - <?php 
        if ($_GET) echo $currentName = $_GET["name"];
        else if ($_POST) echo $currentName = $_POST["name"];
    ?></title>

    <link rel="stylesheet" href="../assets/styles/styles.css">
</head>
<body>
    <?php
        // Init

        $pathArrivals = "../assets/data/arrivals.json";
        $pathStudents = "../assets/data/students.json";

        $currentDate = date("G:i:s - l (jS \of F) - Y");
        $currentHour = date("G");

        $newStudent = true;
        
        if ($currentHour > 20) die("Príchod medzi 20:00 a 24:00 :/");

        // Functions

        function addFileData($path, $data, $append) {
            file_put_contents($path, $data, $append ? FILE_APPEND : null);
        }

        function getFileData($path) {
            $data = null;
            if (file_exists($path)) $data = file_get_contents($path, false, null);

            return !$data ? null : $data;
        }

        // Classes

        class Student {
            public $path;
            public $name;

            private $newStudent = true;

            function setData ($path, $name) {
                $this->path = $path;
                $this->name = $name;
            }

            function setJSON () {
                $allStudents = $this->getAllStudents($this->path);
                
                if (!$allStudents) $allStudents = [];

                for ($i = 0; $i < count($allStudents); $i++) {
                    if ($allStudents[$i]["name"] == $this->name) {
                        if ($_POST && $_POST["action"] == "submitNewArrival") $allStudents[$i]["arrivals"] += 1;
                        $this->newStudent = false;
                    }
                }

                if ($this->newStudent) array_push($allStudents, ["name" => $this->name, "arrivals" => 1]);
                
                $this->putAllStudents($this->path, $allStudents);
            }

            static function setJSONStatic($path, $name) {
                $newStudent = true;

                $allStudents = json_decode(getFileData($path), JSON_PRETTY_PRINT);
                
                if (!$allStudents) $allStudents = [];

                for ($i = 0; $i < count($allStudents); $i++) {
                    if ($allStudents[$i]["name"] == $name) {
                        if ($_POST && $_POST["action"] == "submitNewArrival") $allStudents[$i]["arrivals"] += 1;
                        $newStudent = false;
                    }
                }
                if ($newStudent) array_push($allStudents, ["name" => $name, "arrivals" => 0]);
                
                addFileData($path, json_encode($allStudents, JSON_PRETTY_PRINT), false);
            }

            function getObject() {
                $allStudents = $this->getAllStudents($this->path);

                for ($i = 0; $i < count($allStudents); $i++) {
                    if ($allStudents[$i]["name"] == $this->name) return $allStudents[$i];
                }
            }

            static function getObjectStatic($path, $name) {
                $allStudents = json_decode(getFileData($path), JSON_PRETTY_PRINT);

                for ($i = 0; $i < count($allStudents); $i++) {
                    if ($allStudents[$i]["name"] == $name) return $allStudents[$i];
                }
            }

            // Helpers

            function getAllStudents ($path) {
                return json_decode(getFileData($path), JSON_PRETTY_PRINT);
            }

            function putAllStudents ($path, $allStudents) {
                addFileData($path, json_encode($allStudents, JSON_PRETTY_PRINT), false);
            }
        }

        class Arrivals {
            public $path;
            public $student;
            public $time;
            public $hour;

            function setData ($path, $student, $time, $hour) {
                $this->path = $path;
                $this->student = $student;
                $this->time = $time;
                $this->hour = $hour;
            }

            function setJSON () {
                $allArrivals = $this->getAllArrivals($this->path);
                
                if (!$allArrivals) $allArrivals = [];

                if ($_POST && $_POST["action"] == "submitNewArrival") {
                    array_push($allArrivals, ["student" => $this->student, "time" => $this->time, "hour" => $this->hour, "late" => $this->hour > 8]);
                }

                $this->putAllArrivals($this->path, $allArrivals);
            }

            function getObject () {
                $arr = [];
                $allArrivals = $this->getAllArrivals($this->path);

                for ($i = 0; $i < count($allArrivals); $i++) {
                    if ($allArrivals[$i]["student"] == $this->student) array_push($arr, $allArrivals[$i]);
                }

                return $arr;
            }

            // Helpers

            function getAllArrivals($path) {
                return json_decode(getFileData($path), JSON_PRETTY_PRINT);
            }

            function putAllArrivals($path, $allArrivals) {
                addFileData($path, json_encode($allArrivals, JSON_PRETTY_PRINT), false);
            }
        }

        // Instances

        //$student = new Student();
        //$student->setData($pathStudents, $currentName);
        //$student->setJSON();
        Student::setJSONStatic($pathStudents, $currentName);

        $arrivals = new Arrivals();
        $arrivals->setData($pathArrivals, $currentName, $currentDate, $currentHour);
        $arrivals->setJSON();
    ?>

    <!-- <span class="title">Student Arrivals - <?php echo $student->name ?></span> -->
    <span class="title">Student Arrivals - <?php echo $currentName ?></span>

    <hr class="small">

    <form action="./student.php" method="post">
        <input type="hidden" name="name" value="<?php echo $currentName ?>">
        <input type="hidden" name="action" value="submitNewArrival">
        <input class="submit" type="submit" value="Submit new Arrival">
    </form>

    <hr class="border">
    
    Student:

    <pre><?php
        // print_r($student->getObject());
        print_r(Student::getObjectStatic($pathStudents, $currentName));
    ?></pre>

    <hr class="border">

    Arrivals:

    <pre><?php
        print_r($arrivals->getObject());
    ?></pre>
</body>
</html>