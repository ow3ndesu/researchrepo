<?php
include_once("../process/returns.process.php");
$process = new Process();

if (isset($_POST["action"]) && $_POST["action"] == "LoadReturns") {
    $process->LoadReturns();
}

if (isset($_POST["action"]) && $_POST["action"] == "LoadReturn") {
    $process->LoadReturn($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "EditReturnStatus") {
    $process->EditReturnStatus($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "DeleteReturn") {
    $process->DeleteReturn($_POST);
}
