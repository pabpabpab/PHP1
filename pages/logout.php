<?php
function indexAction() {
    unset($_SESSION['user']);
    session_destroy();
    header("Location: /");
    exit;
}

