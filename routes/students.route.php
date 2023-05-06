<?php
include_once("../process/students.process.php");
$process = new Process();

if (isset($_POST["action"]) && $_POST["action"] == "LoadStudents") {
    $process->LoadStudents();
}

if (isset($_POST["action"]) && $_POST["action"] == "LoadStudent") {
    $process->LoadStudent($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "AddStudent") {
    $process->AddStudent($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "UpdateStudent") {
    $process->UpdateStudent($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "DeleteStudent") {
    $process->DeleteStudent($_POST);
}
