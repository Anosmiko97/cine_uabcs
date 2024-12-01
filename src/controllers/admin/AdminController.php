<?php

require_once "./src/helpers/crud.php";
require_once "./src/config/database.php";
require_once "./src/config/config.php";

class AdminController implements Crud {

    private $conn = Db::getPDO();

    public function read($id) {
        $stmt = $this->conn->prepare("SELECT * FROM ");
        $stmt->execute();
    }

    public function update($id) {
        $stmt = $this->conn->prepare("UPDATE  WHERE = $id ");
        $stmt->execute();
    }

    public function create(array $data) {

    }

    public function delete($id) {

    }

    public function show(): array {
        $stmt = $this->conn->prepare("SELECT * FROM ");
        $stmt->execute();

        return 
    }
    
}