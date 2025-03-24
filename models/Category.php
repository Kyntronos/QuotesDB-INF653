<?php
    class Category {
        private $conn;
        private $table = 'categories';

        //category properties
        public $id;
        public $category;

        public function __construct($db){
            $this->conn = $db;
        }

        //Get categories
        public function read(){
            //Create query
            $query = 'SELECT 
            id, 
            category
            FROM
            ' . $this->table;

            //prepare the statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();

            return $stmt;
        }

        public function read_single(){
            $query = 'SELECT 
            id,
            category
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

            //Check if category exists
            if($row){

            //set properties
            $this->id = $row['id'];
            $this->category= $row['category'];

            } else {
                $this->id = null;
                $this->category = null;
            }
        }

        //Create Category
        public function create(){
            //Create query
            $query = 'INSERT INTO ' . $this->table . ' (category)
            VALUES
                (:category)';

            //Prepar statment
            $stmt = $this->conn->prepare($query);

            //Cleanning data
            $this->category = htmlspecialchars(strip_tags($this->category));

            //Bind data
            $stmt->bindParam(':category', $this->category);

            //Executing query
            if($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("ERROR: %s.\n", $stmt->error);

            return false;

        }

        //Update category
        public function update(){
            //Create query
            $query = 'UPDATE ' . $this->table . '
            SET
                category = :category
            WHERE
                id = :id';

            //Prepar statment
            $stmt = $this->conn->prepare($query);

            //Cleanning data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);

            //Executing query
            if($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("ERROR: %s.\n", $stmt->error);

            return false;

        }
        
        //Delete category
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
                return true;
            }

            //Print error if something goes wrong
            printf("ERROR: %s.\n", $stmt->error);

            return false;
        }

        
    }
    