<?php
$target_file = "/home/cabox/workspace/BULK_UPLOAD/bulk.txt";
$sql = mysql_connect("LOCALHOST", "Saru", "gw");
if (!$sql) {
    die("Could not connect: " . mysql_error());
}
mysql_select_db("Saru");
$result = mysql_query("LOAD DATA INFILE '$target_file'" .
                      " INTO TABLE employees FIELDS TERMINATED BY '|'");
if (!$result) {
    die("Could not load. " . mysql_error());
}
?>