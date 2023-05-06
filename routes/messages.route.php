<?php
include_once("../process/messages.process.php");
$process = new Process();

if (isset($_POST["action"]) && $_POST["action"] == "LoadMessages") {
    $process->LoadMessages($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "SendMessage") {
    $process->SendMessage($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "LoadInbox") {
    $process->LoadInbox();
}
