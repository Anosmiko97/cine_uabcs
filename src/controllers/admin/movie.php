<?php

require_once "./src/helpers/crud.php";  

class movie extends Crud{
    
    public function create(array $data) {
        $stmt = $this->conn->query("INSERT INTO movies VALUE
        ");

    }
}