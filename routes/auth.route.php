<?php
include_once("../process/auth.process.php");
$process = new Process();

if (isset($_POST["action"]) && $_POST["action"] == "Login") {
    $process->Login($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "LoadProfile") {
    $process->LoadProfile();
}

if (isset($_POST["action"]) && $_POST["action"] == "Logout") {
    $process->Logout();
}

if (isset($_POST["action"]) && $_POST["action"] == "Register") {
    $process->Register($_POST);
}

if(isset($_POST["action"]) && $_POST["action"] == "ForgotPassword"){
    $process->ForgotPassword($_POST);
}

if(isset($_POST["action"]) && $_POST["action"] == "VerifyOTP"){
    $process->VerifyOTP($_POST);
}

if(isset($_POST["action"]) && $_POST["action"] == "ResetPassword"){
    $process->ResetPassword($_POST);
}
