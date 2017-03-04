<html>
<head>
<Title>Tag This Wall!</Title>
<link href="https://fonts.googleapis.com/css?family=Gloria Hallelujah" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Margarine" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"> 
<style type="text/css">
    body { background-image: url("images/blockwall.jpg"); border-top: solid 10px DarkRed;
		color: WhiteSmoke; font-size: 1.0em; margin: 20; padding: 20;
        font-family: 'Ubuntu', sans-serif;
		text-align: center;
	}
    .form { width:60%; margin-left: auto; margin-right: auto; padding: 5px;
			background-color: GhostWhite; border: solid 5px MidnightBlue; color: MidnightBlue;
			border-radius: 80px; background-image: url("images/tagger.png"); background-repeat: repeat-x;
			background-position: left center;
	}
	h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; margin-left: auto; margin-right: auto; }
    th { font-size: 1.2em; text-align: center; border-bottom: 5px solid DarkRed; padding: .3em; }
    td { padding: .25em 1.5em; text-align: center; border: 0 none; }
	td.tagger { font-family: 'Margarine';font-size: 30px; color: Gold; text-shadow: 1px 1px Salmon;}
	td.graffiti { font-family: 'Gloria Hallelujah';font-size: 30px; color: Navy; text-shadow: 1px 1px PaleGreen;}
//    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
</head>
<body>
<div class="form">
<h1>Tag this wall!</h1>
<p>Fill in your tagger name and message, then click <strong>Submit</strong> to tag this wall.</p>
<form method="post" action="index.php" enctype="multipart/form-data" >
      Tagger  <input type="text" name="cl_tagger" id="cl_tagger" maxlength="30"/></br>
      Message <input type="text" name="cl_message" id="cl_message" maxlength="128"/></br>
      <input type="submit" name="submit" value="Submit" />
</form>
</div>
<?php

// ***********************************************
// Standard MySQL Connection Strings

// DB connection info
$host = 'dbhost';
$user = 'dbusername';
$pwd = 'dbusernamepassword';
$db = 'database';
// End of Standard MySQL database connectivity
// ***********************************************

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
// End of Azure MySQL In App database connectivity
// ***********************************************

// Get User IP Address
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

// Output IP address [Ex: 192.168.1.100]
$location = getUserIP();


// Connect to database.
try {
    $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(Exception $e){
    die(var_dump($e));
}

// Code to for inserting registration into the database.
if(!empty($_POST)) {
try {
    $cl_tagger = $_POST['cl_tagger'];
    $cl_message = $_POST['cl_message'];
// Sanitize output by stripping HTML characters
    $taggername =  htmlspecialchars($tagname['tagger']);
    $taggermessage =  htmlspecialchars($tagname['message']);
    $date = date("Y-m-d");
// Insert data
    $sql_insert = "INSERT INTO graffiti_tbl (tagger, message, location, date) 
                   VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bindValue(1, $tagger);
    $stmt->bindValue(2, $message);
    $stmt->bindValue(3, $location);
    $stmt->bindValue(4, $date);
    $stmt->execute();
}
catch(Exception $e) {
    die(var_dump($e));
}
echo "<h3>You have tagged this wall!</h3>";
}

// Code for retrieving data from the database.
$sql_select = "SELECT * FROM graffiti_tbl";
$stmt = $conn->query($sql_select);
$taggers = $stmt->fetchAll(); 
if(count($taggers) > 0) {
    echo '<h2>The following people have tagged this wall:</h2>';
    echo '<table>';
    echo '<tr><th>Tagger</th>';
    echo '<th>Message</th>';
//    echo '<th>IP Address</th>';
    echo '<th>Date</th></tr>';
    foreach($taggers as $tagname) {
// Sanitize output for stripping HTML tags
    $taggername = strip_tags($tagname['tagger']);
    $taggermessage = strip_tags($tagname['message']);
// Format the date output
    $taggerdate = date("d M Y",strtotime($tagname['date']));
        echo '<tr><td class="tagger">'.$taggername.'</td>';
        echo '<td class="graffiti">'.$taggermessage.'</td>';
//        echo '<td>'.$tagname['location'].'</td>';		
        echo '<td>'.$taggerdate.'</td></tr>';
    }
     echo '</table>';
} else {
    echo '<h3>No one has tagged this wall yet.</h3>';
}
 
?>
</body>
</html>
 
