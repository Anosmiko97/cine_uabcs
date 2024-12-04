<?php

class Session {

    public static function checkSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin'])) {
            header("Location: /");
            exit;
        }
    }

    public static function checkPrivilege($privilege) {
        self::checkSession();

        if (empty($_SESSION['admin']['privileges'][$privilege])) {
            // Redirigir al panel si no tiene el privilegio necesario
            header("Location: /admin/panel");
            exit;
        }
    }
}
