<?php

use function PHPSTORM_META\type;

include_once("../database/connection.php");
include_once("sanitize.process.php");

class Process extends Database
{
    public function LoadReturns()
    {
        $requests = [];
        $returns = [];
        $sql = "SELECT b.borrow_id, bo.book_id, bo.title, s.student_id, s.lastname, b.status, b.filed, b.due, b.modified_at, r.remarks, r.returned_at FROM (((borrowals b LEFT JOIN books bo ON b.book_id = bo.book_id) LEFT JOIN students s ON b.student_id = s.student_id) LEFT JOIN returns r ON b.borrow_id = r.borrow_id) WHERE b.status = 'RETURNING' OR b.status = 'RETURNED' ORDER BY b.id DESC;";
        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();

                while ($row = $result->fetch_assoc()) {
                    if ($row['status'] == 'RETURNED') {
                        $returns[] = $row;
                    } else {
                        $requests[] = $row;
                    }
                }

                echo json_encode(array(
                    "MESSAGE" => "RETURNS_LOADED",
                    "REQUESTS" => $requests,
                    "RETURNS" => $returns
                ));
            } else {
                echo json_encode(array(
                    "MESSAGE" => "NO_RETURNS",
                ));
            }
        } else {
            echo 'EXECUTION_ERROR';
        }
    }

    public function LoadReturn($data)
    {
        $return = [];
        $sanitize = new Sanitize();
        $borrow_id = $sanitize->sanitizeForString($data["borrow_id"]);
        $returnloaded = "RETURN_LOADED";
        $nodata = "NO_DATA";

        $stmt = $this->conn->prepare("SELECT b.*, bo.*, s.*, u.*, r.* FROM ((((borrowals b LEFT JOIN books bo ON b.book_id = bo.book_id) LEFT JOIN students s ON b.student_id = s.student_id) LEFT JOIN users u ON s.user_id = u.user_id) LEFT JOIN returns r ON b.book_id = r.borrow_id) WHERE b.borrow_id = ? ORDER BY b.id DESC;");
        $stmt->bind_param("s", $borrow_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();

        if ($res->num_rows > 0) {

            while ($rows = $res->fetch_array()) {
                $return[] = $rows;
            }

            unset($return[0][33]);

            echo json_encode(array(
                "MESSAGE" => $returnloaded,
                "RETURN" => $return,
            ));
        } else {
            echo $nodata;
        }
    }

    public function EditReturnStatus($data)
    {
        $sanitize = new Sanitize();
        $borrow_id = $sanitize->sanitizeForString($data["borrow_id"]);
        $status = $sanitize->sanitizeForString($data["status"]);
        $reason = $sanitize->sanitizeForString($data["reason"]);
        $modified_at = date('m/d/Y');
        $admin_id = $_SESSION['admin_id'];

        $stmt = $this->conn->prepare("UPDATE borrowals SET status = ?, modified_at = ?, modified_by = ? WHERE borrow_id = ?;");
        $stmt->bind_param("ssss", $status, $modified_at, $admin_id, $borrow_id);

        $stmt1 = $this->conn->prepare("SELECT book_id FROM borrowals WHERE borrow_id = ?;");
        $stmt1->bind_param("s", $borrow_id);

        if ($stmt->execute()) {
            $stmt->close();

            $stmt = $this->conn->prepare("SELECT u.receiver FROM ((borrowals b LEFT JOIN students s ON s.student_id = b.student_id) LEFT JOIN users u ON u.user_id = s.user_id) WHERE b.borrow_id = ?;");
            $stmt->bind_param("s", $borrow_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            include_once('email.process.php');
            $email = new Email;
            $email->SendReturnStatusEmailNotification($row['receiver'], $status);

            $stmt1->execute();
            $res1 = $stmt1->get_result();
            $stmt1->close();
            $row = $res1->fetch_array();
            $book_id = $row[0];

            if ($status == 'RETURNED') {
                $stmt = $this->conn->prepare("UPDATE books SET quantity = quantity + 1 WHERE book_id = ?;");
                $stmt->bind_param("s", $book_id);
                $stmt->execute();
                $stmt->close();

                $stmt = $this->conn->prepare("INSERT INTO returns (borrow_id, remarks, returned_at) VALUES (?, ?, ?);");
                $stmt->bind_param("sss", $borrow_id, $reason, $modified_at);
                $stmt->execute();
                $stmt->close();

                echo 'UPDATE_SUCCESSFUL';
            } else {
                $stmt = $this->conn->prepare("INSERT INTO returns (borrow_id, remarks) VALUES (?, ?);");
                $stmt->bind_param("ss", $borrow_id, $reason);
                $stmt->execute();
                $stmt->close();

                echo 'UPDATE_SUCCESSFUL';
            }
        } else {
            $stmt->close();
            echo 'UPDATE_ERROR';
        }
    }

    public function DeleteReturn($data)
    {
        $sanitize = new Sanitize();
        $borrow_id = $sanitize->sanitizeForString($data["borrow_id"]);

        $stmt = $this->conn->prepare("DELETE b, r FROM borrowals b INNER JOIN returns r ON r.borrow_id = b.borrow_id WHERE b.borrow_id = ?;");
        $stmt->bind_param("s", $borrow_id);

        if ($stmt->execute()) {
            $stmt->close();
            echo 'DELETE_SUCCESSFUL';
        } else {
            $stmt->close();
            echo 'DELETE_ERROR';
        }
    }
}
