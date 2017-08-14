<?php

$reservations = array(
    'index' => function() {
        global $db;
        $user = intval(getUser($_SERVER['HTTP_TOKEN']));

        $query = "
            select reservations.id, user_id, locations.name as loc_name, address, services.name as ser_name, date, time_start, time_end, state from reservations
                join locations on locations.id = location_id
                join services on services.id = service_id
                join users on users.id = user_id
        ";

        if (isset($_GET['location_id']) && isset($_GET['date'])) {
            $location_id = $_GET['location_id'];
            $date = $_GET['date'];
            $query .= " where reservations.location_id = $location_id and reservations.date = '$date' and state = 'pending'";
        }
        else {
            $query .= " where user_id = $user";
        }

        $stmt = $db->query($query);

        $data = array();
        while($row = $stmt->fetch_assoc()) {
            array_push($data, $row);
        }
        return json_encode($data);
    },

    'create' => function() {
        global $db;
        $user = intval(getUser($_SERVER['HTTP_TOKEN']));
        $location_id = $_POST['location_id'];
        $service_id = $_POST['service_id'];
        $date = $_POST['date'];
        $time_start = $_POST['time_start'];
        $time_end = $_POST['time_end'];

        $stmt = $db->query("
            insert into reservations (user_id, location_id, service_id, date, time_start, time_end, state) values
                ($user, $location_id, $service_id, '$date', '$time_start', '$time_end', 'pending');
        ");

        return json_encode(array('success' => $stmt));
    },

    'cancel' => function() {
        global $db;
        $id = $_POST['id'];
        
        $stmt = $db->query("update reservations set state = 'fail' where id = $id");

        return json_encode(array('success' => $stmt));
    }
);