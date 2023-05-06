<?php
include_once("../process/profile.process.php");
$process = new Process();

if (isset($_POST["action"]) && $_POST["action"] == "LoadProfile") {
    $process->LoadProfile();
}

if (isset($_POST["action"]) && $_POST["action"] == "UpdateProfile") {
    $process->UpdateProfile($_POST);
}

// if (isset($_POST["action"]) && $_POST["action"] == "LoadNonEnabledUsers") {
//     $process->LoadNonEnabledUsers();
// }

// if (isset($_POST["action"]) && $_POST["action"] == "LoadUser") {
//     $process->LoadUser($_POST);
// }

// if (isset($_POST["action"]) && $_POST["action"] == "EditUserStatus") {
//     $process->EditUserStatus($_POST);
// }

// if (isset($_POST["action"]) && $_POST["action"] == "DeleteUserAccount") {
//     $process->DeleteUserAccount($_POST);
// }
