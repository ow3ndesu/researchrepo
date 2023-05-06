<?php

use function PHPSTORM_META\type;

include_once("../database/connection.php");
include_once("sanitize.process.php");

class Process extends Database
{

    public function LoadMessages($data)
    {
        $messages = [];
        if (isset($_SESSION['admin_id'])) {
            $id = $data['student_id'];
            $query = "SELECT * FROM messages WHERE student_id = ? ORDER BY reply_to ASC;";
        } else {
            $id = $_SESSION['student_id'];
            $query = "SELECT * FROM messages WHERE student_id = ? ORDER BY reply_to ASC;";
        }

        $messagesloaded = "MESSAGES_LOADED";
        $nodata = "NO_DATA";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();

        if ($res->num_rows > 0) {

            while ($rows = $res->fetch_assoc()) {
                $messages[] = $rows;
            }

            echo json_encode(array(
                "MESSAGE" => $messagesloaded,
                "MESSAGES" => $messages,
            ));
        } else {
            echo $nodata;
        }
    }

    public function LoadInbox()
    {
        $inbox = [];
        $inboxloaded = "INBOX_LOADED";
        $nodata = "NO_DATA";

        $query = "SELECT s.firstname, s.middlename, s.lastname, m.* FROM messages m INNER JOIN students s ON s.student_id = m.student_id WHERE m.id IN (SELECT MAX(id) FROM messages GROUP BY student_id) ORDER BY `m`.`created_at` DESC;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();

        if ($res->num_rows > 0) {

            while ($rows = $res->fetch_assoc()) {
                $inbox[] = $rows;
            }

            echo json_encode(array(
                "MESSAGE" => $inboxloaded,
                "INBOX" => $inbox,
            ));
        } else {
            echo $nodata;
        }
    }

    public function SendMessage($data) {
        $sanitize = new Sanitize();
        $student_id = (isset($_SESSION['student_id']) ? $_SESSION['student_id'] : $data['student_id']);
        $message = $sanitize->sanitizeForString($data["message"]);
        $reply_to = $sanitize->sanitizeForString($data["reply_to"]);
        $created_at = date('F d, Y h:ia');

        if (isset($_SESSION['student_id'])) {
            $stmt = $this->conn->prepare("INSERT INTO messages (student_id, message, reply_to, created_at) VALUES (?, ?, ?, ?);");
            $stmt->bind_param("ssss", $student_id, $message, $reply_to, $created_at);
        } else {
            $isAdmin = 1;
            $stmt = $this->conn->prepare("INSERT INTO messages (student_id, message, reply_to, isAdmin, created_at) VALUES (?, ?, ?, ?, ?);");
            $stmt->bind_param("sssss", $student_id, $message, $reply_to, $isAdmin, $created_at);
        }
        

        if ($stmt->execute()) {
            $stmt->close();
            echo 'SENT_SUCCESSFUL';
        } else {
            $stmt->close();
            echo 'SENT_ERROR';
        }
    }
}
