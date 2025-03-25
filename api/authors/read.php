<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Authors.php');

    $database = new Database();
    $db = $database->connect();

    //Instantiate category

    $Authors = new Authors($db);

    //category read query
    $result = $Authors->read();

    //get row count
    $num = $result->rowCount();

    //Check if any quotes
    if($num > 0){
        //cat array
        $auth_arr = array();
        

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $auth_item = array(
                'id' => $id,
                'author' => $author
                
            );
            //push to 'data'
            array_push($auth_arr, $auth_item);
        }

        //turn to JSON
        echo json_encode($auth_arr);
    } else {
        //No categories
        echo json_encode(array('message' => 'No Authors found'));

    }