<?php

class Session {

    public static function checkSession($requiredRole = null) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin'])) {
            header("Location: /");
            exit;
        }

        if ($requiredRole && $_SESSION['privileges'] !== $requiredRole) {
            header("Location: /");
            exit;
        }

        return true;
    }
}
