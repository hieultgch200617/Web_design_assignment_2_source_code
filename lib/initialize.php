<?php
function redirect_to($location) {
    header("Location: " . $location);
    exit;
}

$errors = [];

function isFormValidated(){
    global $errors;
    return count($errors) == 0;
}

session_start();

if (!isset($_SESSION['accountRoles'])){
    return $_SESSION['accountRoles'] = "";
}

if (!isset($_SESSION['status'])){
    return $_SESSION['status'] = 0;
}

