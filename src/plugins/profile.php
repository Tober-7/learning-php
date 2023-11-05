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
        $pathStudent = "../assets/classes/student.php";
        $pathArrivals = "../assets/classes/arrivals.php";

        $currentDate = date("G:i:s - l (jS \of F) - Y");
        $currentHour = date("G");

        $newStudent = true;
        
        if ($currentHour > 20) die("Príchod medzi 20:00 a 24:00 :/");

        require($pathStudent);
        require($pathArrivals);

        Student::getStudentInfo($currentName);

        $arrivals = new Arrivals($currentName, $currentDate, $currentHour);
        $arrivals->getArrivalsInfo();
    ?>

    <span class="title">Student Arrivals - <?php echo $currentName ?></span>

    <hr class="small">

    <form action="./profile.php" method="post">
        <input type="hidden" name="name" value="<?php echo $currentName ?>">
        <input type="hidden" name="action" value="submitNewArrival">
        <input class="submit" type="submit" value="Submit new Arrival">
    </form>

    <hr class="border">
    
    <?php $student = Student::getStudent($currentName) ?>
    Student: <?php echo $student["name"]; ?> (<?php echo $student["arrivals"]; ?> arrivals)

    <hr class="border">

    Arrivals:

    <?php
        foreach ($arrivals->getArrivals() as $arrival) {
            $late = $arrival["late"] ? " - meškanie" : "";
            echo "<br>{$arrival["time"]}{$late}";
        }
    ?>
</body>
</html>