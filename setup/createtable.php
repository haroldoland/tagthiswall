<?php

// ***********************************************
// Standard MySQL Connection Strings
// ***********************************************

//*** DB connection info
$host = 'dbhost';
$user = 'dbusername';
$pwd = 'dbusernamepassword';
$db = 'database';
$port = '3306';

//*** Connect using mysqli
//$conn = new mysqli($host, $user, $pwd, $db, $port);  //*** For using $port
$conn = new mysqli($host, $user, $pwd, $db);
//*** Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// ***********************************************
// End of Standard MySQL database connectivity
// ***********************************************

// ***********************************************
// Azure MySQL Connection Strings
// ***********************************************
//*** Uncomment the sections below to use on Azure websites with MySQL In App
//*** Make sure to comment out the Standard MySQL Connection Strings above

//$AzureConnString = $_SERVER['MYSQLCONNSTR_localdb'];
//$AzureConnStringPieces = explode(";", $AzureConnString);
//foreach ($AzureConnStringPieces as $piece) {
    //*** Parse each piece of the string creating $Data_Source (Server:Port), $User_Id (Username), $Password, $Database (DBName)
    //*** IE. Data Source=127.0.0.1:45678 --> $Data_Source = "127.0.0.1:45678"
//    parse_str($piece);
//}

//*** Separate host from port in Data_Source
//$source = explode(":", $Data_Source);
//$Host = $source[0];
//$Port = $source[1];

//*** Create connection
//$conn = new mysqli($Host, $User_Id, $Password, $Database, $Port);
//if ($conn->connect_error){
//    die("Connection failed: " . $conn->connect_error);
//} 
// ***********************************************
// End of Azure MySQL In App database connectivity
// ***********************************************

//*** sql to create table
$sql = "CREATE TABLE graffiti_tbl(
        id INT NOT NULL AUTO_INCREMENT, 
        PRIMARY KEY(id),
        tagger VARCHAR(30),
        message VARCHAR(128),
        location VARCHAR (16),
        date DATE)";

if ($conn->query($sql) === TRUE) {
    echo "<h3>Table created.</h3>";
} else {
    echo "Error creating table: " . $conn->error;
}

//*** Close mysqli connection
$conn->close();

?>
