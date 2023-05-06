<?php

use function PHPSTORM_META\type;

include_once("../database/connection.php");
include_once("sanitize.process.php");

class Process extends Database
{
    public function LoadUsers()
    {
        $users = [];
        $sql = "SELECT * FROM users WHERE user_type != 'ADMIN';";
        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();

                while ($row = $result->fetch_assoc()) {
                    $users[] = $row;
                }

                echo json_encode(array(
                    "MESSAGE" => "USERS_LOADED",
                    "USERS" => $users
                ));
            } else {
                echo json_encode(array(
                    "MESSAGE" => "NO_USER",
                ));
            }
        } else {
            echo 'EXECUTION_ERROR';
        }
    }

    public function LoadNonEnabledUsers()
    {
        $users = [];
        $sql = "SELECT * FROM users WHERE user_type != 'ADMIN' AND status != 'ENABLED';";
        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();

                while ($row = $result->fetch_assoc()) {
                    $users[] = $row;
                }

                echo json_encode(array(
                    "MESSAGE" => "USERS_LOADED",
                    "USERS" => $users
                ));
            } else {
                echo json_encode(array(
                    "MESSAGE" => "NO_USER",
                ));
            }
        } else {
            echo 'EXECUTION_ERROR';
        }
    }

    public function LoadUser($data)
    {
        $user = [];
        $sanitize = new Sanitize();
        $user_id = $sanitize->sanitizeForString($data["user_id"]);
        $userloaded = "USER_LOADED";
        $nodata = "NO_DATA";

        $stmt = $this->conn->prepare("SELECT user_id, email, proof, user_type, status, created_at FROM users WHERE user_id = ?;");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();

        if ($res->num_rows > 0) {

            while ($rows = $res->fetch_assoc()) {
                $user[] = $rows;
            }

            echo json_encode(array(
                "MESSAGE" => $userloaded,
                "USER" => $user,
            ));
        } else {
            echo $nodata;
        }
    }

    public function EditUserStatus($data)
    {
        $sanitize = new Sanitize();
        $user_id = $sanitize->sanitizeForString($data["user_id"]);
        $status = $sanitize->sanitizeForString($data["status"]);

        $stmt = $this->conn->prepare("UPDATE users SET status = ? WHERE user_id = ?;");
        $stmt->bind_param("ss", $status, $user_id);

        if ($stmt->execute()) {
            $stmt->close();

            $stmt = $this->conn->prepare("SELECT receiver FROM users WHERE user_id = ?;");
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ($status = 'ENABLED') {
                $stmt = $this->conn->prepare("SELECT * FROM students WHERE user_id = ?");
                $stmt->bind_param("s", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 0) {
                    $stmt->close();
                    $student_id = $sanitize->generateSID();
                    $created_at = date('m/d/Y');

                    $stmt = $this->conn->prepare("INSERT INTO students (student_id, user_id, created_at) VALUES (?, ?, ?);");
                    $stmt->bind_param("sss", $student_id, $user_id, $created_at);
                    $stmt->execute();
                    $stmt->close();

                    echo 'UPDATE_SUCCESSFUL';
                } else {
                    $stmt->close();
                    echo 'UPDATE_SUCCESSFUL';
                }
            } else {
                echo 'UPDATE_SUCCESSFUL';
            }
        } else {
            $stmt->close();
            echo 'UPDATE_ERROR';
        }
    }

    public function DeleteUserAccount($data)
    {
        $sanitize = new Sanitize();
        $user_id = $sanitize->sanitizeForString($data["user_id"]);

        $stmt = $this->conn->prepare("DELETE FROM students WHERE user_id = ?;");
        $stmt->bind_param("s", $user_id);

        if ($stmt->execute()) {
            $stmt->close();
            
            $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = ?;");
            $stmt->bind_param("s", $user_id);

            if ($stmt->execute()) {
                $stmt->close();
                echo 'DELETE_SUCCESSFUL';
            } else {
                $stmt->close();
                echo 'DELETE_ERROR';
            }
        } else {
            $stmt->close();
            echo 'DELETE_ERROR';
        }
    }
}
