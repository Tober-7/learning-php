<?php

$pathHelpers = "../assets/classes/helpers.php";

require_once($pathHelpers);

class Arrivals {
    const path = "../assets/data/arrivals.json";

    public $student;
    public $time;
    public $hour;

    function __construct ($student, $time, $hour) {
        $this->student = $student;
        $this->time = $time;
        $this->hour = $hour;
    }

    function getArrivalsInfo () {
        $allArrivals = Helpers::getJSONData(Arrivals::path);

        if ($_POST && $_POST["action"] == "submitNewArrival") {
            array_push($allArrivals, ["student" => $this->student, "time" => $this->time, "hour" => $this->hour, "late" => $this->hour > 8]);
        }

        Helpers::addFileData(Arrivals::path, json_encode($allArrivals, JSON_PRETTY_PRINT));
    }

    function getArrivals () {
        $arr = [];
        $allArrivals = Helpers::getJSONData(Arrivals::path);

        foreach ($allArrivals as $arrival) {
            if ($arrival["student"] == $this->student) array_push($arr, $arrival);
        }

        return $arr;
    }
}

?>