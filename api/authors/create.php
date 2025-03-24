<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Methods: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once('../../config/Database.php');
    include_once('../../models/Authors.php');

    $database = new Database();
    $db = $database->connect();

    //Instantiate author

    $Authors = new Authors($db);

    //Get raw data
    $data = json_decode(file_get_contents('php://input'));

    $Authors->id = $data->id;
    $Authors->author = $data->author;

    //Create post
    if($Authors->create()){
        echo json_encode(
            array(
                'id' => $data->id,
                'author'=> $data->author
            )
        );
    } else {
        echo json_encode(
            array('message' => "Author Not Created")
        );
    }