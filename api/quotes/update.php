<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Methods: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once('../../config/Database.php');
    include_once('../../models/Quote.php');

    $database = new Database();
    $db = $database->connect();

    //Instantiate quote

    $Quote = new Quote($db);

    //Get raw data
    $data = json_decode(file_get_contents('php://input'));

    //Set ID to update
    $Quote->id = $data->id;
    $Quote->quote = $data->quote;
    $Quote->author_id = $data->author_id;
    $Quote->category_id = $data->category_id;

    //Update quote
    if($Quote->update()){
        echo json_encode(
            array('message' => 'Post updated')
        );
    } else {
        echo json_encode(
            array('message' => "Post Not updated")
        );
    }