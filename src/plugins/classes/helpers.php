<?php

class Helpers {
    static function addFileData($path, $data) {
        file_put_contents($path, $data);
    }
    
    static function getFileData($path) {
        $data = "";
        if (file_exists($path)) $data = file_get_contents($path);
    
        return $data;
    }

    static function getJSONData($path) {
        $arr = Helpers::getFileData($path);
        if (gettype(json_decode($arr, JSON_PRETTY_PRINT)) == "array") $arr = json_decode($arr, JSON_PRETTY_PRINT);
        else $arr = [];

        return $arr;
    }
}

?>