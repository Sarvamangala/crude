<?php
//To look for the name in database for autocomplete

define('DB_SERVER', 'LOCALHOST');
define('DB_USERNAME', 'Saru');
define('DB_PASSWORD', 'gw');
define('DB_NAME', 'Saru');


if (isset($_GET['term'])){
    $return_arr = array();

    try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
      $stmt = $pdo->prepare('SELECT name FROM employees WHERE name LIKE :term');
        $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
        
        while($row = $stmt->fetch()) {
            $return_arr[] =  $row['name'];
        }

    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }


    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}

  
?>