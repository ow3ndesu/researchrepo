<?php
include_once("../process/faculties.process.php");
$process = new Process();

if (isset($_POST["action"]) && $_POST["action"] == "LoadFaculties") {
    $process->LoadFaculties();
}

if (isset($_POST["action"]) && $_POST["action"] == "LoadFaculty") {
    $process->LoadFaculty($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "AddFaculty") {
    $process->AddFaculty($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "UpdateFaculty") {
    $process->UpdateFaculty($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "DeleteFaculty") {
    $process->DeleteFaculty($_POST);
}
