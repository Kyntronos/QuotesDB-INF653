<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Methods: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once('../../config/Database.php');
    include_once('../../models/Authors.php');

    $database = new Database();
    $db = $database->connect();

    //Instantiate quote

    $Author = new Authors($db);

    //Get raw data
    $data = json_decode(file_get_contents('php://input'));

    

    //Set ID to update
    //$Author->id = $data->id;
    $Author->author = $data->author;

    if (!isset($data->id, $data->author)) {
        echo json_encode(['message' => 'Missing Required Parameters']);
        exit;
    }

    //Update quote
    if($Author->update()){
        echo json_encode(
            array(
                'id' => $Authors->id,
                'author'=> $Authors->author
            )
        );
    } else {
        echo json_encode(
            array('message' => "Author Not updated")
        );
    }