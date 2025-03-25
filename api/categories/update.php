<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Methods: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once('../../config/Database.php');
    include_once('../../models/Category.php');

    $database = new Database();
    $db = $database->connect();

    //Instantiate quote

    $Category = new Category($db);

    //Get raw data
    $data = json_decode(file_get_contents('php://input'));

    if (!isset($data->category)) {
        echo json_encode(['message' => 'Missing Required Parameters']);
        exit;
    }

    //Set ID to update
    $Category->id = $data->id;
    $Category->category = $data->category;

    

    //Update quote
    if($Category->update()){
        echo json_encode(
            array(
                'id' => $Category->id,
                'category' => $Category->category
            )
        );
    }/* else {
        echo json_encode(
            array('message' => "Category Not updated")
        );
    }
    */