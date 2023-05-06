<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/PHPMailer/Exception.php';
require '../assets/PHPMailer/PHPMailer.php';
require '../assets/PHPMailer/SMTP.php';

include_once("../database/connection.php");
include_once("sanitize.process.php");

class Process extends Database
{

    public function Register($data)
    {
        $sanitize = new Sanitize();
        $username = $sanitize->sanitizeForString($data["email"]);
        $receiver = $sanitize->sanitizeForEmail($data["email2"]);
        $password = $sanitize->sanitizeForString($data["password"]);
        $passwordmd5 = md5($password);
        $proof = $_FILES["proof"];
        $type = "STUDENT";
        $status = "DISABLED"; // DISABLED/ENABLED
        $createdat = date('m/d/Y');
        $created_at = strval($createdat);

        $usernameinuse = "USERNAME_ALREADY_IN_USE";
        $emailinuse = "EMAIL_ALREADY_IN_USE";
        $registered = "REGISTER_SUCCESS";

        $path = '../assets/uploaded/proofs/';
        $tmpname = $proof["tmp_name"];
        $filename = $proof["name"];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = $username."-". rand(90, 2000) .".".$ext;

        $query = "SELECT username FROM users where username = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();

        $query = "SELECT receiver FROM users where receiver = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $receiver);
        $stmt->execute();
        $res = $stmt->get_result();

        $stmt->close();

        if ($result->num_rows == 1) {
            echo $usernameinuse;
        } else if ($res->num_rows == 1) {
            echo $emailinuse;
        } else {
            if (move_uploaded_file($tmpname, $path.$filename)) {
                $stmt = $this->conn->prepare("INSERT INTO users(username, receiver, password, proof, user_type, status, created_at) VALUES (?,?,?,?,?,?,?);");
                $stmt->bind_param("sssssss", $username, $receiver, $passwordmd5, $filename, $type, $status, $created_at);
    
                if ($stmt->execute()) {
                    $stmt->close();
                    echo $registered;
                } else {
                    echo "THIS IS A DB OR CONNECTION ERROR";
                }
            } else {
                echo 'UPLOAD_ERROR';
            }
        }
    }

    public function Login($data)
    {
        $sanitize = new Sanitize();
        $username = $sanitize->sanitizeForString($data["email"]);
        $password = $sanitize->sanitizeForString($data["password"]);
        $passwordmd5 = md5($password);

        $sql = "SELECT u.*, IF(s.is_completed IS NULL, 0, s.is_completed) AS isCompleted FROM users u LEFT JOIN students s ON s.user_id = u.user_id WHERE username = ?;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($result->num_rows > 0) {
            if (($row["password"] == $passwordmd5)) {
                if ($row["status"] == "ENABLED") {
                    $_SESSION["authenticated"] = "1";
                    $_SESSION["userid"] = $row["user_id"];
                    $_SESSION["user_type"] = $row["user_type"];
                    $_SESSION["isCompleted"] = $row["isCompleted"];
                    $url = "pages/home.page.php";
                    $_SESSION['attempts'] = 3;

                    if ($row["user_type"] == "ADMIN" || $row["user_type"] == "FACULTY") {
                        $_SESSION["admin-auth"] = "1";
                        $url = "admin/index.php";
                    }

                    $this->LoadProfileNoReturn();

                    echo json_encode(array(
                        "MESSAGE" => "LOGIN_SUCCESS",
                        "URL" => $url
                    ));

                    
                } else if ($row["status"] == "DISABLED") {
                    echo json_encode(array(
                        "MESSAGE" => "ACCOUNT_INACTIVE",
                    ));
                } else {
                    echo json_encode(array(
                        "MESSAGE" => "ACCOUNT_DEACTIVATED",
                    ));
                }
            } else {
                $_SESSION['attempts'] = $_SESSION['attempts'] - 1;
                echo json_encode(array(
                    "MESSAGE" => "INCORRECT_COMBINATION",
                    "ATTEMPTS" => $_SESSION['attempts']
                ));
            }
        } else {
            echo json_encode(array(
                "MESSAGE" => "NO_USER_FOUND",
            ));
        }
    }

    public function LoadProfileNoReturn()
    {
        $user_type = $_SESSION["user_type"];
        $user_id = $_SESSION["userid"];

        if ($user_type == 'ADMIN') {
            $sql = "SELECT * FROM admins WHERE user_id = ?;";
        } else if ($user_type == 'FACULTY') {
            $sql = "SELECT * FROM faculties WHERE user_id = ?;";
        } else {
            $sql = "SELECT * FROM students WHERE user_id = ?;";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $user_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();

                while ($row = $result->fetch_assoc()) {
                    if (isset($row["admin_id"]) && $row["admin_id"]) {
                        $_SESSION['admin_id'] = $row['admin_id'];
                    } else if (isset($row["student_id"]) && $row["student_id"]) {
                        $_SESSION['student_id'] = $row['student_id'];
                    } else if (isset($row["faculty_id"]) && $row["faculty_id"]) {
                        $_SESSION['faculty_id'] = $row['faculty_id'];
                    }

                    $_SESSION['fullname'] = $row['firstname'] . ' ' . $row['lastname'];
                }
            }
        }
    }

    public function LoadProfile()
    {
        $user_type = $_SESSION["user_type"];
        $user_id = $_SESSION["userid"];

        if ($user_type == 'ADMIN') {
            $sql = "SELECT * FROM admins WHERE user_id = ?;";
        } else if ($user_type == 'FACULTY') {
            $sql = "SELECT * FROM faculties WHERE user_id = ?;";
        } else {
            $sql = "SELECT * FROM students WHERE user_id = ?;";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $user_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();

                while ($row = $result->fetch_assoc()) {
                    if (isset($row["admin_id"]) && $row["admin_id"]) {
                        $_SESSION['admin_id'] = $row['admin_id'];
                    } else if (isset($row["student_id"]) && $row["student_id"]) {
                        $_SESSION['student_id'] = $row['student_id'];
                    } else if (isset($row["faculty_id"]) && $row["faculty_id"]) {
                        $_SESSION['faculty_id'] = $row['faculty_id'];
                    }

                    $_SESSION['fullname'] = $row['firstname'] . ' ' . $row['lastname'];
                }

                echo json_encode(array(
                    "MESSAGE" => "PROFILE_LOADED",
                ));
            } else {
                echo json_encode(array(
                    "MESSAGE" => "NO_PROFILE",
                ));
            }
        } else {
            echo 'EXECUTION_ERROR';
        }
    }

    public function Logout()
    {
        if (session_destroy()) {
            echo "LOGOUT_SUCCESS";
            session_start();
            $_SESSION['attempts'] = 3;
        } else {
            echo "LOGOUT_UNSUCCESSFUL";
        }
    }

    public function ForgotPassword($data)
    {
        $sanitize = new Sanitize();
        $username = $sanitize->sanitizeForEmail($data["username"]);
        $email = $sanitize->sanitizeForEmail($data["email"]);
        $nonexistent = "EMAIL_NOTEXIST";
        $notsent = "NOT_SENT";
        $verifiersent = "VERIFIER_SENT";

        //check if email exist
        $query = "SELECT * FROM users where username = ? AND receiver = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        // $result->num_rows == 1             //replace as an if parameter
        if ($result->num_rows == 1) {

            // generate and store otp code?create link etc
            $shufflethis = '0123456789';
            $otp = substr(str_shuffle($shufflethis), 0, 6);
            $created = date("Y-m-d H:i:s");
            $BODY = "Your One-Time Password (OTP) is " . $otp . ". Kindly use this to proceed with the next process. Disregard this email if you did not make the request.";

            // delete previous data - helps with preventing user to access previous codes to verify password changing || optional, can be changed kung may mas okay na method. for testing
            $del = "DELETE FROM verifier WHERE email = ?";
            $stmt = $this->conn->prepare($del);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();

            $sql = "INSERT INTO verifier (email, otp, created_at) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sss", $email, $otp, $created);

            if ($stmt->execute()) {
                $stmt->close();

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = EMAIL_RSS;
                $mail->Password = EMAIL_RSSPASS;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER; #COMMENTED/REMOVED TO ENSURE THIS FUNCTION DOES NOT RETURN ANY VALUE WHICH IS NOT A JSON FILE
                $mail->Port = 587;
                $mail->SetFrom('researchreposys@gmail.com','Research Repository System Notification');
                $mail->addAddress($email);
                $mail->addReplyTo('no-reply@gmail.com','NO-REPLY');
                $mail->Subject = 'One-Time Password (OTP)';
                $mail->isHTML(true);
                $body = file_get_contents("../EmailOTPFormat.html");
                $body = str_replace('%otp%',$otp,$body);
                $mail->MsgHTML($body);

                if ($mail->Send()) {
                    echo $verifiersent;
                } else {
                    echo $notsent;
                }
            }
        } else {
            echo $nonexistent;
        }
    }

    public function VerifyOTP($data)
    {
        $sanitize = new Sanitize();
        $otp = $sanitize->sanitizeForString(strval($data["otp"]));
        $email = $sanitize->sanitizeForEmail($data["email"]);
        $codeaccepted = "CODE_ACCEPTED";
        $wrongcode = "WRONG_CODE";
        $expiredcode = "EXPIRED_CODE";



        // check if OTP exist
        $query = "SELECT * FROM verifier WHERE email = ? AND otp = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $email, $otp);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows == 1) {
            // check if otp is not expired
            $sql = "SELECT * FROM verifier WHERE is_expired != 1 AND (email = ? AND NOW() <= DATE_ADD(created_at, INTERVAL 5 minute))";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows == 1) {
                // set otp as expired
                $expired = "UPDATE verifier SET is_expired = 1 WHERE otp = ?";
                $stmt = $this->conn->prepare($expired);
                $stmt->bind_param("s", $otp);
                $stmt->execute();
                $stmt->close();

                echo $codeaccepted;
            } else {

                echo $expiredcode;
            }
        } else {

            echo $wrongcode;
        }
    }

    public function ResetPassword($data)
    {

        $sanitize = new Sanitize();
        $email = $sanitize->sanitizeForEmail($data["email"]);
        $updatequery = "UPDATE users SET password = ? where receiver = ?";
        $wrongpassword = "WRONG_PASSWORD";
        $samepassword = "SAME_PASSWORD";
        $passwordchanged = "PASSWORD_CHANGED";

        // check if old password is set to filter out if the request is coming from otp reset function or from changing password via providing an old one
        if (isset($data["oldpassword"])) {

            $oldpasswordmd5 = md5($sanitize->sanitizeForString($data["oldpassword"]));
            $checkquery = "SELECT * FROM users WHERE receiver = ? AND password = ?";
            $stmt = $this->conn->prepare($checkquery);
            $stmt->bind_param("ss", $email, $oldpasswordmd5);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            //check if the old password matches
            if ($result->num_rows == 1) {

                $password = $sanitize->sanitizeForString($data["password"]);
                $passwordmd5 = md5($password);
                
                // check if the input new password is the same with the one stored from db
                if ($passwordmd5 === $sanitize->sanitizeForString($row["password"])) {
                    echo $samepassword;
                } else {

                    $stmt = $this->conn->prepare($updatequery);
                    $stmt->bind_param("ss", $passwordmd5, $email);

                    if ($stmt->execute()) {
                        $stmt->close();
                        echo $passwordchanged;
                    }
                }
            } else {
                echo $wrongpassword;
            }
        } else {
            
            $password = $data["password"];
            $passwordmd5 = md5($password);
            $stmt = $this->conn->prepare($updatequery);
            $stmt->bind_param("ss", $passwordmd5, $email);

            if ($stmt->execute()) {
                $stmt->close();
                echo $passwordchanged;
            }
        }
    }
}
