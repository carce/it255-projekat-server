<?php

$services = array(
    'index' => function() {
        $locationId = $_GET['location_id'];

        global $db;
        $stmt = $db->query("select * from services where location_id = $locationId");

        $data = array();
        while($row = $stmt->fetch_assoc()) {
            array_push($data, $row);
        }
        
        return json_encode($data);
    }
);