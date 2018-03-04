<?php
$target_dir = "/home/cabox/workspace/BULK_UPLOAD/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
if(isset($_POST["submit"])) {
$sql = mysql_connect("localhost", "Saru", "gw");
if (!$sql) {
    die("Could not connect: " . mysql_error());
}
mysql_select_db("Saru");
$result = mysql_query("LOAD DATA INFILE '$target_file'" .
                      " INTO TABLE employees FIELDS TERMINATED BY '|'");
if (!$result) {
    die("Could not load. " . mysql_error());
}
}
?>