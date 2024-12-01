<?php

/**
 * Interfaz para crud basico
 */
interface Crud {
    public function read($id);
    public function update($id);
    public function create(array $data);
    public function delete($id);

}