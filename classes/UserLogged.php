<?php

class UserLogged {
    private $loggedIn;
    private $userLevel;

    public function __construct() {
        // session_start();
        $this->checkUserLoggedIn();
    }

    private function checkUserLoggedIn() {
        if (isset($_SESSION['user']['logged']) && $_SESSION['user']['logged'] == "1") {
            $this->loggedIn = true;
            $this->userLevel = $_SESSION['user']['level'];

            $this->redirectBasedOnLevel();
        } else {
            $this->loggedIn = false;
        }
    }

    private function redirectBasedOnLevel() {
        switch ($this->userLevel) {
            case "1":
                header("Location: ../administracao/inicio");
                exit();
            case "2":
                header("Location: ../painel/inicio");
                exit();
        }
    }

    public function isLoggedIn() {
        return $this->loggedIn;
    }

    public function getUserLevel() {
        return $this->userLevel;
    }
}
