<?php
    class Authors {
        private $conn;
        private $table = 'authors';

        //post properties
        public $id;
        public $author;

        public function __construct($db){
            $this->conn = $db;
        }

        //Get authors
        public function read(){
            //Create query
            $query = 'SELECT 
            id, 
            author
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
            author
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

            //set properties
            $this->id = $row['id'];
            $this->author= $row['author'];
        }

        //Create Category
        public function create(){
            //Create query
            $query = 'INSERT INTO ' . $this->table . ' (author)
            VALUES
                (:author)';

            //Prepar statment
            $stmt = $this->conn->prepare($query);

            //Cleanning data
            $this->author = htmlspecialchars(strip_tags($this->author));

            //Bind data
            $stmt->bindParam(':author', $this->author);

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
                author = :author
            WHERE
                id = :id';

            //Prepar statment
            $stmt = $this->conn->prepare($query);

            //Cleanning data
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':author', $this->author);
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
    