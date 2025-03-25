<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Methods: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once('../../config/Database.php');
    include_once('../../models/Authors.php');

    $database = new Database();
    $db = $database->connect();

    //Instantiate quote

    $Authors = new Authors($db);

    //Get raw data
    $data = json_decode(file_get_contents('php://input'));

    //Set ID to update
    $Authors->id = $data->id;


    //Delete quote
    if($Authors->delete()){
        echo json_encode(
            array(
                'id' => $Authors->id
            )
        );
    } else {
        echo json_encode(
            array('message' => "Author Not deleted")
        );
    }