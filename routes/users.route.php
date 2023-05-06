<?php
include_once("../process/users.process.php");
$process = new Process();

if (isset($_POST["action"]) && $_POST["action"] == "LoadUsers") {
    $process->LoadUsers();
}

if (isset($_POST["action"]) && $_POST["action"] == "LoadNonEnabledUsers") {
    $process->LoadNonEnabledUsers();
}

if (isset($_POST["action"]) && $_POST["action"] == "LoadUser") {
    $process->LoadUser($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "EditUserStatus") {
    $process->EditUserStatus($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "DeleteUserAccount") {
    $process->DeleteUserAccount($_POST);
}
