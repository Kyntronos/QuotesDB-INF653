<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Category.php');

    $database = new Database();
    $db = $database->connect();

    //Instantiate quote

    $Category = new Category($db);

    //Get ID

    $Category->id = isset($_GET['id']) ? $_GET['id'] : die();

    //Get post
    $Category->read_single();

    //Create array
    $cat_arr = array(
        'id' => $Category->id,
        'category' => $Category->category,
    );

    //Make JSON
    print_r(json_encode($cat_arr));
