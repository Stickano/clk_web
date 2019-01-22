<?php

@session_start();
include_once("../models/curl.php");
include_once("../models/validators.php");

$val  = new Validators();
$curl = new Curl();
$curl->showError(true);

# On login
if (isset($_POST['okLogin'])){

    $pwHash = hash('sha256', $_POST['clk_upass']);
    $data   = ['email' => $_POST['clk_uname'], 'password' => $pwHash];

    $curl->post($data);

    $return = $curl->curl("http://easj-final.azurewebsites.net/Service1.svc/profile/login");

    if ($return['id'] == null)
        $_SESSION['error'] = "No valid user found. Check you E-mail and Password.";
    else
        $_SESSION['clk_uid'] = ['id' => $return['id'], 'passw' => $pwHash, 'uname' => $result['username'], 'email' => strtolower($_POST['clk_uname'])];
}

# On new profile register
if (isset($_POST['okSignUp'])){

    # We dont want empty values
    if (   empty($_POST['clk_uname'])
        || empty($_POST['clk_upass'])
        || !$val->valMail($_POST['clk_uname'])){
        $_SESSION['error'] = "Missing (or invalid) E-mail or Password value.";
        header("location:../index.php");
    }

    $pwHash = hash('sha256', $_POST['clk_upass']);
    $data   = ['email' => $_POST['clk_uname'], 'password' => $pwHash];

    $curl->post($data);

    $return = $curl->curl("http://easj-final.azurewebsites.net/Service1.svc/profile/create");

    if ($return == 1)
        $_SESSION['message'] = "Account created. You can now login with the provided credencials.";
    else
        $_SESSION['error'] = "Something went wrong. Are you already registered?";
}

header("location:../index.php?Profile");

?>