<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Include config file
require_once 'config.php';
require '/home/cabox/workspace/PHPMailer-master/src/Exception.php';
require '/home/cabox/workspace/PHPMailer-master/src/PHPMailer.php';
require '/home/cabox/workspace/PHPMailer-master/src/SMTP.php';
 
// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = 'Please enter an address.';     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = 'Please enter a positive integer value.';
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary) VALUES (:name, :address, :salary)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':name', $param_name);
            $stmt->bindParam(':address', $param_address);
            $stmt->bindParam(':salary', $param_salary);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
    // Configuring SMTP server settings
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'LOCALHOST';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = "shyamravichandran2534@gmail.com";
            $mail->Password = "FriendsForever2534.";

// Email Sending Details
        //    $to_id="angadi.saru@gmail.com"
            $mail->addAddress('angadi.saru@gmail.com');
            $mail->Subject = "employee database";
            $message="new field added";
            $mail->msgHTML($message);

// Success or Failure
            if (!$mail->send()) {
            $error = "Mailer Error: " . $mail->ErrorInfo;
            echo '<p id="para">'.$error.'</p>';
            }
            else {
            echo '<p id="para">Message sent!</p>';
            }

                // Records created successfully. Redirect to landing page
                header("location: dashboard.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input id="name" type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea id="address" name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input id="salary" type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="upload.php" class="btn btn-default">Upload!</a>
                        <a href="dashboard.php" class="btn btn-default">Cancel</a>
                    </form>
                  <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
                  <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>    
                  <script type="text/javascript">
                  $(function() {
    
                  //autocomplete
                  $("#name").autocomplete({
                  source: "search.php",
                  minLength: 1
                                  });  
                   $("#address").autocomplete({
                  source: "search_address.php",
                  minLength: 1
                                  });  
                   $("#salary").autocomplete({
                  source: "search_address.php",
                  minLength: 1
                                  });  
                   });
                  </script>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>