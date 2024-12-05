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
        $_SESSION = [];
    
        // Eliminar cookie si existe
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, 
                      $params["path"], $params["domain"], 
                      $params["secure"], $params["httponly"]);
        }
    
        session_destroy();
        header("Location: /");
        exit;
    }
    
}
