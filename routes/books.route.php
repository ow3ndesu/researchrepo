<?php
include_once("../process/books.process.php");
$process = new Process();

if (isset($_POST["action"]) && $_POST["action"] == "LoadBooks") {
    $process->LoadBooks();
}

if (isset($_POST["action"]) && $_POST["action"] == "LoadBook") {
    $process->LoadBook($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "AddBook") {
    $process->AddBook($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "UpdateBook") {
    $process->UpdateBook($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "DeleteBook") {
    $process->DeleteBook($_POST);
}
