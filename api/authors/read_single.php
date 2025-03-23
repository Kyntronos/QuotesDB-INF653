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

    $Author->id = isset($_GET['id']) ? $_GET['id'] : die();

    //Get post
    $Author->read_single();

    //Create array
    $auth_arr = array(
        'id' => $Author->id,
        'author' => $Author->author,
    );

    //Make JSON
    print_r(json_encode($auth_arr));
