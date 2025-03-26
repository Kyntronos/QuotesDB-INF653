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
    
    if (!isset($data->id, $data->quote, $data->author_id, $data->category_id)) {
        echo json_encode(['message' => 'Missing Required Parameters']);
        exit;
    }

    //Set ID to update
    $Quote->id = $data->id;
    $Quote->quote = $data->quote;
    $Quote->author_id = $data->author_id;
    $Quote->category_id = $data->category_id;


    //Update quote
    if($Quote->update()){
        echo json_encode(
            array(
                
                'id' => $Quote->id,
                'quote' => $Quote->quote,
                'author_id' => $Quote->author_id,
                'category_id' => $Quote->category_id
                
            )
        );
    }  else {
        echo json_encode(
            array('message' => "No Quotes Found")
        );
    }
    
