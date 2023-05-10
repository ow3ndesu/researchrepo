<?php
include_once("../process/researches.process.php");
$process = new Process();

if (isset($_POST["action"]) && $_POST["action"] == "LoadResearches") {
    $process->LoadResearches();
}

if (isset($_POST["action"]) && $_POST["action"] == "LoadResearch") {
    $process->LoadResearch($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "AddResearch") {
    $process->AddResearch($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "UpdateResearch") {
    $process->UpdateResearch($_POST);
}

if (isset($_POST["action"]) && $_POST["action"] == "DeleteResearch") {
    $process->DeleteResearch($_POST);
}
