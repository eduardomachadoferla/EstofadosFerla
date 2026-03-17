<?php
session_start();

function admin_logado() {
    return isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true;
}

function exigir_login() {
    if (!admin_logado()) {
        header('Location: login.php');
        exit;
    }
}