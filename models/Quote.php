<?php
    class Quote {
        private $conn;
        private $table = 'quotes';

        //quotes properties
        public $id;
        public $quote;
        public $author_id;
        public $category_id;

        //Constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        //Get Quotes
        public function read(){
            //Create query
            $query = 'SELECT 
            id, quote, author_id, category_id
            FROM ' . $this->table;

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();

            return $stmt;
        }

        //Get single quote
        public function read_single(){
            $query = 'SELECT 
            id, quote, author_id, category_id
            FROM ' . $this->table . '
            WHERE id = ?
            LIMIT 1 OFFSET 0';

            //Pepare statement
            $stmt = $this->conn->prepare($query);

            //Bind ID
            $stmt->bindParam(1, $this->id);

            //Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Check if the quote exists
            if($row){

            //set properties
            $this->quote = $row['quote'];
            $this->author_id = $row['author_id'];
            $this->category_id = $row['category_id'];

            } else {
                $this->quote = null;
                $this->author_id = null;
                $this->category_id = null;
            }
            
        }

        //Create quote
        public function create(){
            // Check if author_id exists in the authors table
            $author_check_query = "SELECT id FROM authors WHERE id = :author_id LIMIT 1";
            $stmt = $this->conn->prepare($author_check_query);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->execute();

            // If the author_id doesn't exist, return an error message
            if ($stmt->rowCount() == 0) {
                echo json_encode(array('message' => 'author_id Not Found'));
                return false;
            }

            $category_check_query = "SELECT id FROM categories WHERE id = :category_id LIMIT 1";
            $stmt = $this->conn->prepare($category_check_query);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->execute();

            // If the author_id doesn't exist, return an error message
            if ($stmt->rowCount() == 0) {
                echo json_encode(array('message' => 'category_id Not Found'));
                return false;
            }
                
            //Create query
            $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id)
            VALUES
                (:quote,
                :author_id,
                :category_id)';

            //Prepar statment
            $stmt = $this->conn->prepare($query);

            //Cleanning data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            //Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            //Executing query
            if($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("ERROR: %s.\n", $stmt->error);

            return false;

        }

        //Update quote
        public function update(){
            // Check if author_id exists in the authors table
            $author_check_query = "SELECT id FROM authors WHERE id = :author_id LIMIT 1";
            $stmt = $this->conn->prepare($author_check_query);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->execute();

            // If the author_id doesn't exist, return an error message
            if ($stmt->rowCount() == 0) {
                echo json_encode(array('message' => 'author_id Not Found'));
                return false;
            }

            $category_check_query = "SELECT id FROM categories WHERE id = :category_id LIMIT 1";
            $stmt = $this->conn->prepare($category_check_query);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->execute();

            // If the author_id doesn't exist, return an error message
            if ($stmt->rowCount() == 0) {
                echo json_encode(array('message' => 'category_id Not Found'));
                return false;
            }

            
            
            //Create query
            $query = 'UPDATE ' . $this->table . '
            SET
                quote = :quote,
                author_id = :author_id,
                category_id = :category_id
            WHERE
                id = :id';

            //Prepar statment
            $stmt = $this->conn->prepare($query);

            //Cleanning data
            $this->quote = htmlspecialchars(strip_tags($this->quote ?? ''));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id ?? ''));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id ?? ''));
            $this->id = htmlspecialchars(strip_tags($this->id ?? ''));

            //Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);

            //Executing query
            if($stmt->execute()){
                if($stmt->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }

            //Print error if something goes wrong
            printf("ERROR: %s.\n", $stmt->error);

            return false;

        }
        
        //Delete Quote
        public function delete(){
            //create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            //Prepar statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()){
                if($stmt->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }
        

            //Print error if something goes wrong
            printf("ERROR: %s.\n", $stmt->error);

            return false;
        }

        
    }