<?php

use function PHPSTORM_META\type;

include_once("../database/connection.php");
include_once("sanitize.process.php");

class Process extends Database
{
    public function LoadResearches()
    {
        $researches = [];
        (isset($_SESSION['admin_id'])) ? $sql = "SELECT * FROM researches;" : $sql = "SELECT * FROM researches WHERE status != 'INACTIVE';";
        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();

                while ($row = $result->fetch_assoc()) {
                    $researches[] = $row;
                }

                echo json_encode(array(
                    "MESSAGE" => "RESEARCHES_LOADED",
                    "RESEARCHES" => $researches
                ));
            } else {
                echo json_encode(array(
                    "MESSAGE" => "NO_RESEARCHES",
                ));
            }
        } else {
            echo 'EXECUTION_ERROR';
        }
    }

    public function LoadResearch($data)
    {
        $research = [];
        $sanitize = new Sanitize();
        $research_id = $sanitize->sanitizeForString($data["research_id"]);
        $researchloaded = "RESEARCH_LOADED";
        $nodata = "NO_DATA";

        $stmt = $this->conn->prepare("SELECT * FROM researches WHERE research_id = ?;");
        $stmt->bind_param("s", $research_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();

        if ($res->num_rows > 0) {

            while ($rows = $res->fetch_assoc()) {
                $research[] = $rows;
            }

            echo json_encode(array(
                "MESSAGE" => $researchloaded,
                "RESEARCH" => $research,
            ));
        } else {
            echo $nodata;
        }
    }

    public function AddResearch($data)
    {
        $sanitize = new Sanitize();
        $research_id = $sanitize->generateRID();
        $image = $_FILES["image"];
        $copy = $_FILES["copy"];
        $title = $sanitize->sanitizeForString($data["title"]);
        $author = $sanitize->sanitizeForString($data["author"]);
        $description = $sanitize->sanitizeForString($data["description"]);
        $status = $sanitize->sanitizeForString($data["status"]);
        $inserted_by = ($_SESSION["user_type"] == 'ADMIN') ? $_SESSION["admin_id"] : $_SESSION["faculty_id"];
        $inserted_at = date('m/d/Y');

        $path = '../assets/uploaded/images/';
        $tmpname = $image["tmp_name"];
        $filename = $image["name"];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = $research_id."-". $author .".".$ext;
        
        if (move_uploaded_file($tmpname, $path.$filename)) {

            $filepath = '../assets/uploaded/copies/';
            $copytmpname = $copy["tmp_name"];
            $copyfilename = $copy["name"];
            $copyext = pathinfo($copyfilename, PATHINFO_EXTENSION);
            $copyfilename = $research_id."-". $author .".".$copyext;
            
            if (move_uploaded_file($copytmpname, $filepath.$copyfilename)) {

                $stmt = $this->conn->prepare("INSERT INTO researches (research_id, image, copy, title, author, description, status, inserted_by, inserted_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");
                $stmt->bind_param("sssssssss", $research_id, $filename, $copyfilename, $title, $author, $description, $status, $inserted_by, $inserted_at);
                $stmt->execute();
                // printf("Error: %s.\n", $stmt->error);
                // $stmt->close();

                if ($stmt->execute()) {
                    $stmt->close();
                    echo 'ADDING_SUCCESSFUL';
                } else {
                    $stmt->close();
                    echo 'EXECUTION_ERROR';
                }
            } else {
                echo 'UPLOAD_ERROR';
            }
        } else {
            echo 'UPLOAD_ERROR';
        }
    }

    public function UpdateResearch($data)
    {
        $sanitize = new Sanitize();
        $research_id = $sanitize->sanitizeForString($data["research_id"]);
        $title = $sanitize->sanitizeForString($data["title"]);
        $author = $sanitize->sanitizeForString($data["author"]);
        $description = $sanitize->sanitizeForString($data["description"]);
        $status = $sanitize->sanitizeForString($data["status"]);

        $stmt = $this->conn->prepare("UPDATE researches SET title = ?, author = ?, description = ?, status = ? WHERE research_id = ?;");
        $stmt->bind_param("sssss", $title, $author, $description, $status, $research_id);

        if ($stmt->execute()) {
            $stmt->close();
            echo 'UPDATE_SUCCESSFUL';
        } else {
            $stmt->close();
            echo 'UPDATE_ERROR';
        }
    }

    public function DeleteResearch($data)
    {
        $sanitize = new Sanitize();
        $research_id = $sanitize->sanitizeForString($data["research_id"]);

        $stmt = $this->conn->prepare("DELETE FROM researches WHERE research_id = ?;");
        $stmt->bind_param("s", $research_id);

        if ($stmt->execute()) {
            $stmt->close();
            echo 'DELETE_SUCCESSFUL';
        } else {
            $stmt->close();
            echo 'DELETE_ERROR';
        }
    }
}
