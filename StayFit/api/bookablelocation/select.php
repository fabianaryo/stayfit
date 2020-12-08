<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/bookablelocation.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate equipment purchase object
    $bookable_loc = new bookablelocation($db);

    //Get Space ID
    $bookable_loc->Space_ID = isset($_GET['Space_ID']) ? $_GET['Space_ID']: die();

    //Select
    $bookable_loc->select();

    //Check for bookings

        $bookable_loc_arr = array(
                'Space_ID' =>$bookable_loc->Space_ID,
                'Space_name' =>$bookable_loc->Space_name,
                'Location' => $bookable_loc->Location,
                'Capacity' => $bookable_loc->Capacity,
                'Open_time' => $bookable_loc->Open_time,
                'Close_time' => $bookable_loc->Close_time,
                'Price' => $bookable_loc->Price

            );

        //Turn to JSON & output
        echo json_encode($bookable_loc_arr);
