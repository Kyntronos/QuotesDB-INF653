<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Category.php');

    $database = new Database();
    $db = $database->connect();

    //Instantiate category

    $Category = new Category($db);

    //category read query
    $result = $Category->read();

    //get row count
    $num = $result->rowCount();

    //Check if any quotes
    if($num > 0){
        //cat array
        $cat_arr = array();
        $cat_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $cat_item = array(
                'id' => $id,
                'category' => $category
                
            );
            //push to 'data'
            array_push($cat_arr['data'], $cat_item);
        }

        //turn to JSON
        echo json_encode($cat_arr);
    } else {
        //No categories
        echo json_encode(array('message' => 'No categories found'));

    }