<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Include config file

require '/home/cabox/workspace/PHPMailer-master/src/Exception.php';
require '/home/cabox/workspace/PHPMailer-master/src/PHPMailer.php';
require '/home/cabox/workspace/PHPMailer-master/src/SMTP.php';
require '/home/cabox/workspace/PHPMailer-master/src/OAuth.php';
$target_file = "/home/cabox/workspace/BULK_UPLOAD/bulk.txt";
$sql = mysql_connect("LOCALHOST", "Saru", "gw");
if (!$sql) {
    die("Could not connect: " . mysql_error());
}
mysql_select_db("Saru");
$result = mysql_query("LOAD DATA INFILE '$target_file'" .
                      " INTO TABLE employees FIELDS TERMINATED BY '|'");

 $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Debugoutput = 'html';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = "akeys2503@gmail.com";
            $mail->Password = "superwoman";

// Email Sending Details
        //    $to_id="bshelton2517@gmail.com"
            $mail->setFrom('akeys2503@gmail.com','sender');
            $mail->addAddress('bshelton2517@gmail.com','receiver');
            $mail->Subject = "employee database";
            $message="Bulk of records uploaded";
            $mail->msgHTML($message);

// Success or Failure
            if ($mail->send()) {
              header( "refresh:5; url=dashboard.php" );
           echo '<p id="para">Message sent!</p>';
              
            }
            else {
               $error = "Mailer Error: " . $mail->ErrorInfo;
            echo '<p id="para">'.$error.'</p>';
            exit();
            }

if (!$result) {
    die("Could not load. " . mysql_error());
}

 

?>