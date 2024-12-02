<?php
/**
 * Edta clase tiene algunas funciones basicas
 * para crud
 */

class Crud {
    public $conn = Db::getPDO();

    public function read($id, $table) {
        $stmt = $this->conn->query("SELECT * FROM $table WHERE id = $id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $table, $column, $value) {
        $stmt = $this->conn->query("UPDATE $$table SET $column = $value WHERE id = $id");
    }

    public function delete($id, $table) {
        $stmt = $this->conn->execute("DELETE * FROM $table WHERE id = $id");
    }

    public function readAll($table) {
        $stmt = $this->conn->query("SELECT * FROM $table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}