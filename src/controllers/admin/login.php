<?php

require_once "./src/helpers/crud.php";
require_once "./src/config/database.php";
require_once "./src/config/config.php";

class LoginController {

    private $conn = Db::getPDO();

    public function startSession($name, $privileges) {
        session_start();
        $_SESSION['admin'] = $name;
        $_SESSION['privileges'] = $privileges;
    }

    public function getSessionData(): array {
        return $_SESSION;
    }

    public function stopSession() {
        session_destroy();
    }
}