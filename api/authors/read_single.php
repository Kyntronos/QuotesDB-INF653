<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Authors.php');

    $database = new Database();
    $db = $database->connect();

    //Instantiate quote

    $Author = new Authors($db);

    //Get ID

    $Author->id = isset($_GET['id']) ? $_GET['id'] : null;

    if($Author-> id === null){
        echo json_encode(array('message' => 'No author found.'));
        exit;
    }

    //Get post
    $Author->read_single();

    //Check if category exists
    if ($Author->author === null || $Author->id === null) {
        echo json_encode(array('message' => 'author_id Not Found'));
        exit();
    }

    //Create array
    $auth_arr = array(
        'id' => $Author->id,
        'author' => $Author->author,
    );

    //Make JSON
    print_r(json_encode($auth_arr));
