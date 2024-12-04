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
            header("Location: /admin/panel");
            exit;
        }
    }

    public static function checkPrivilegeWithReturn($privilege) {
        self::checkSession();

        if (!empty($_SESSION['admin']['privileges'][$privilege])) {
            return true;            
        }

        return false;
    }

    public static function logout() {
        // Iniciar sesión si no lo está 
        /*
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        } */

        $_SESSION = [];
        session_destroy();
        header("Location: /");
        exit;
    }
}
