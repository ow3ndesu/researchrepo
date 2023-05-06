<?php
include_once("../process/borrowals.process.php");
$process = new Process();

// ADMIN

if (isset($_POST["action"]) && $_POST["action"] == "LoadBorrowals") {
    $process->LoadBorrowals();
}

if (isset($_POST["action"]) && $_POST["action"] == "LoadBorrowed") {
    $process->LoadBorrowed();
}

if (isset($_POST["action"]) && $_POST["action"] == "LoadBorrowal") {
    $process->LoadBorrowal($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "EditBorrowalStatus") {
    $process->EditBorrowalStatus($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "DeleteBorrowal") {
    $process->DeleteBorrowal($_POST);
}

// USER

if (isset($_POST["action"]) && $_POST["action"] == "BorrowBook") {
    $process->BorrowBook($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "LoadMyBorrowals") {
    $process->LoadMyBorrowals($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "EditMyBorrowalStatus") {
    $process->EditMyBorrowalStatus($_POST);
}
