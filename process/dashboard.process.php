<?php

use function PHPSTORM_META\type;

include_once("../database/connection.php");
include_once("sanitize.process.php");

class Process extends Database
{
    public function LoadDashboard()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(books.id) AS books, (SELECT COUNT(borrowals.id) FROM borrowals WHERE borrowals.status = 'BORROWED' OR borrowals.status = 'RETURNED' OR borrowals.status = 'RETURNING') AS borrowed, (SELECT COUNT(borrowals.id) FROM borrowals WHERE borrowals.status = 'RETURNED') AS returned, (SELECT COUNT(students.id) FROM students) AS students FROM books;");

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();
                
                $row = $result->fetch_assoc();
                
                echo json_encode(array(
                    "MESSAGE" => "DASHBOARD_LOADED",
                    "BOOKS" => $row['books'],
                    "BORROWED" => $row['borrowed'],
                    "RETURNED" => $row['returned'],
                    "STUDENTS" => $row['students'],

                ));
            } else {
                echo json_encode(array(
                    "MESSAGE" => "NOTHING_RETURNED",
                ));
            }
        } else {
            echo 'EXECUTION_ERROR';
        }
    }

    public function LoadNotifications()
    {
        $notifications = [];
        $stmt = $this->conn->prepare("SELECT b.*, s.firstname FROM borrowals b INNER JOIN students s ON b.student_id = s.student_id WHERE status = 'PENDING' OR status = 'RETURNING' ORDER BY b.id DESC;");
        $stmt1 = $this->conn->prepare("SELECT u.* FROM users u WHERE u.status = 'DISABLED' AND u.user_id NOT IN (SELECT s.user_id FROM students s) ORDER BY u.user_id DESC;");

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            
            if ($stmt1->execute()) {
                $result1 = $stmt1->get_result();
                $stmt1->close();
                
                while ($row1 = $result1->fetch_assoc()) {
                    array_push($notifications, $row1);
                }

                while ($row = $result->fetch_assoc()) {
                    array_push($notifications, $row);
                }
                
                echo json_encode(array(
                    "NOTIFICATIONS" => $notifications
                ));
            } else {
                echo 'EXECUTION_ERROR';
            }
        } else {
            echo 'EXECUTION_ERROR';
        }
    }
}
