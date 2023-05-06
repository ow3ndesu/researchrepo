<?php

include_once("../database/connection.php");
include_once("sanitize.process.php");

class Process extends Database
{
    public function LoadFaculties()
    {
        $faculties = [];
        $sql = "SELECT s.faculty_id, s.firstname, s.middlename, s.lastname, s.contact_no FROM faculties s INNER JOIN users u ON u.user_id = s.user_id;";
        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();

                while ($row = $result->fetch_assoc()) {
                    $faculties[] = $row;
                }

                echo json_encode(array(
                    "MESSAGE" => "FACULTIES_LOADED",
                    "FACULTIES" => $faculties
                ));
            } else {
                echo json_encode(array(
                    "MESSAGE" => "NO_FACULTIES",
                ));
            }
        } else {
            echo 'EXECUTION_ERROR';
        }
    }

    public function LoadFaculty($data)
    {
        $faculty = [];
        $sanitize = new Sanitize();
        $faculty_id = $sanitize->sanitizeForString($data["faculty_id"]);
        $facultyloaded = "FACULTY_LOADED";
        $nodata = "NO_DATA";

        $stmt = $this->conn->prepare("SELECT * FROM faculties WHERE faculty_id = ?;");
        $stmt->bind_param("s", $faculty_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();

        if ($res->num_rows > 0) {

            while ($rows = $res->fetch_assoc()) {
                $faculty[] = $rows;
            }

            echo json_encode(array(
                "MESSAGE" => $facultyloaded,
                "FACULTY" => $faculty,
            ));
        } else {
            echo $nodata;
        }
    }

    public function AddFaculty($data)
    {
        $sanitize = new Sanitize();
        $username = $sanitize->sanitizeForString($data["username"]);
        $email = $sanitize->sanitizeForEmail($data["email"]);
        $password = $data["password"];
        $firstname = $sanitize->sanitizeForString($data["firstname"]);
        $middlename = $sanitize->sanitizeForString($data["middlename"]);
        $lastname = $sanitize->sanitizeForString($data["lastname"]);
        $address = $sanitize->sanitizeForString($data["address"]);
        $contactno = $data["contact_no"];
        $created_at = date('m/d/Y');

        $sql = "SELECT username FROM users WHERE username = ? LIMIT 1;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();

        if ($res->num_rows == 1) {
            echo 'Username already used!';
            return;
        }

        $sql = "SELECT receiver FROM users WHERE receiver = ? LIMIT 1;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $resv = $stmt->get_result();
        $stmt->close();

        if ($resv->num_rows == 1) {
            echo 'Email already used!';
            return;
        }

        $md5password = md5($password);

        $stmt = $this->conn->prepare("INSERT INTO users (username, receiver, password, proof, user_type, status, created_at) VALUES ('$username', '$email', '$md5password', '-', 'FACULTY', 'ENABLED', '$created_at');");
        $stmt->execute();
        $stmt->close();

        $stmt = $this->conn->prepare("SELECT LAST_INSERT_ID() as user_id;");
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        $user_id = ($res->fetch_assoc())['user_id'];

        $faculty_id = $sanitize->generateFID();

        $stmt = $this->conn->prepare("INSERT INTO faculties (faculty_id, user_id, firstname, middlename, lastname, address, contact_no, is_completed, created_at) VALUES (?, ?, ?, ?, ?, ?,  ?, '1', ?);");
        $stmt->bind_param("ssssssss", $faculty_id, $user_id, $firstname, $middlename, $lastname, $address, $contactno, $created_at);
        $stmt->execute();
        $stmt->close();

        echo 'ADD_SUCCESSFUL';
    }

    public function UpdateFaculty($data)
    {
        $sanitize = new Sanitize();
        $faculty_id = $sanitize->sanitizeForString($data["faculty_id"]);
        $firstname = $sanitize->sanitizeForString($data["firstname"]);
        $middlename = $sanitize->sanitizeForString($data["middlename"]);
        $lastname = $sanitize->sanitizeForString($data["lastname"]);
        $address = $sanitize->sanitizeForString($data["address"]);
        $contact_no = $sanitize->sanitizeForString($data["contact_no"]);
        $created_at = $sanitize->sanitizeForString($data["created_at"]);

        $stmt = $this->conn->prepare("UPDATE faculties SET firstname = ?, middlename = ?, lastname = ?, address = ?, contact_no = ?, created_at = ? WHERE faculty_id = ?;");
        $stmt->bind_param("sssssss", $firstname, $middlename, $lastname, $address, $contact_no, $created_at, $faculty_id);

        if ($stmt->execute()) {
            $stmt->close();

            echo 'UPDATE_SUCCESSFUL';
        } else {
            $stmt->close();
            echo 'UPDATE_ERROR';
        }
    }

    public function DeleteFaculty($data)
    {
        $sanitize = new Sanitize();
        $faculty_id = $sanitize->sanitizeForString($data["faculty_id"]);

        $stmt = $this->conn->prepare("DELETE FROM faculties WHERE faculty_id = ?;");
        $stmt->bind_param("s", $faculty_id);

        if ($stmt->execute()) {
            $stmt->close();
            echo 'DELETE_SUCCESSFUL';
        } else {
            $stmt->close();
            echo 'DELETE_ERROR';
        }
    }
}
