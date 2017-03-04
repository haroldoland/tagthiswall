<?php

// ***********************************************
// Standard MySQL Connection Strings

// DB connection info
$host = 'dbhost';
$user = 'dbusername';
$pwd = 'dbusernamepassword';
$db = 'database';
// ***********************************************
// End of Standard MySQL database connectivity

// ***********************************************
// Azure MySQL Connection Strings
// Uncomment the sections below to use on Azure websites with MySQL In App
// Make sure to comment out the Standard MySQL Connection Strings above

// $connectstr_dbhost = '';
// $connectstr_dbname = '';
// $connectstr_dbusername = '';
// $connectstr_dbpassword = '';

// foreach ($_SERVER as $key => $value) {
//     if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
//       continue;
//     }
    
//     $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
//     $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
//     $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
//     $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
// }

// DB connection info
// $host = $connectstr_dbhost;
// $user = $connectstr_dbusername;
// $pwd = $connectstr_dbpassword;
// $db = $connectstr_dbname;
// ***********************************************
// End of Azure MySQL In App database connectivity

try{
    $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $sql = "CREATE TABLE graffiti_tbl(
                id INT NOT NULL AUTO_INCREMENT, 
                PRIMARY KEY(id),
                tagger VARCHAR(30),
                message VARCHAR(128),
				location VARCHAR (16),
                date DATE)";
    $conn->query($sql);
}
catch(Exception $e){
    die(print_r($e));
}
echo "<h3>Table created.</h3>";
?>
 