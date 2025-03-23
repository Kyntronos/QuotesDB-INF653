<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Quote.php');

    $database = new Database();
    $db = $database->connect();

    //Instantiate quote

    $Quote = new Quote($db);

    //quote query
    $result = $Quote->read();

    //get row count
    $num = $result->rowCount();

    //Check if any quotes
    if($num > 0){
        //quotes array
        $quotes_arr = array();
        $quotes_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author_id' => $author_id,
                'category_id' => $category_id
                
            );
            //push to 'data'
            array_push($quotes_arr['data'], $quote_item);
        }

        //turn to JSON
        echo json_encode($quotes_arr);
    } else {
        //No quotes
        echo json_encode(array('message' => 'No quotes found'));

    }