<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Quote.php');

    $database = new Database();
    $db = $database->connect();

    //Instantiate quote

    $Quote = new Quote($db);

    //Get ID

    $Quote->id = isset($_GET['id']) ? $_GET['id'] : print_r(json_encode(array('message' => 'No quote found.')));

    //Get post
    $Quote->read_single();

    //Create array
    $Quotes_arr = array(
        'id' => $Quote->id,
        'quote' => $Quote->quote,
        'author' => $Quote->author_id,
        'category' => $Quote->category_id,
    );

    //Make JSON
    print_r(json_encode($Quotes_arr));
