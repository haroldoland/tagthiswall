<html>
<head>
    <Title>Tag This Wall!</Title>
    <meta name="keywords" content="digital grafitti, block wall" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Gloria Hallelujah" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Margarine" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=McLaren" rel="stylesheet"> 
    <style type="text/css">
        body { background-image: url("images/blockwall.jpg"); border-top: solid 10px DarkRed;
	           color: WhiteSmoke; margin: 20; padding: 20; font-family: 'McLaren', sans-serif;

	    }
        .splash { width:70%; margin-left: auto; margin-right: auto; padding: 5px;
	        background-color: GhostWhite; border: solid 5px MidnightBlue; color: DarkBlue;
	        border-radius: 60px; background-image: url("images/tagger.png"); background-repeat: repeat-x;
	        background-position: left center;
	    }
 	    h1, h2, h3, h4 { margin-bottom: 5; padding-bottom: 5; }
        table { margin-top: 0.75em; margin-left: auto; margin-right: auto; }
        th { font-size: 1.2em; text-align: center; border-bottom: 5px solid DarkRed; padding: .3em; }
        td { padding: .25em 1.5em; text-align: center; border: 0 none; }
        td.tagger { font-family: 'Margarine';font-size: 30px; color: Gold; text-shadow: 1px 1px Salmon;}
        td.graffiti { font-family: 'Gloria Hallelujah';font-size: 30px; color: Navy; text-shadow: 1px 1px PaleGreen;}
    </style>
</head>

<body>

<div class="container-fluid text-center">

<div class="splash">
<h1><strong>Tag this wall!</strong></h1>
<h4>Fill in your tagger name and message, then click <strong>Submit</strong> to tag this wall.</h4>

<form class="form-horizontal" action="index.php" method="post" enctype="multipart/form-data">

<div class="form-group <?php echo !empty($cl_taggerError)?'error':'';?>">
    <label class="col-sm-3 control-label">Tagger</label>
    <div class="col-sm-7">
       <input name="cl_tagger" type="text" class="form-control" maxlength="30" placeholder="Tagger Name" value="<?php echo !empty($cl_tagger)?$cl_tagger:'';?>">

                        <?php if (!empty($cl_taggerError)): ?>
                            <span class="help-inline"><?php echo $cl_taggerError;?></span>
                        <?php endif; ?>

    </div> <!-- end col-sm-7 -->
</div> <!-- end form-group -->

<div class="form-group <?php echo !empty($cl_messageError)?'error':'';?>">
    <label class="col-sm-3 control-label">Message</label>
    <div class="col-sm-7">
       <input name="cl_message" type="text" class="form-control" maxlength="128" placeholder="Message" value="<?php echo !empty($cl_message)?$cl_message:'';?>">

                        <?php if (!empty($cl_messageError)): ?>
                            <span class="help-inline"><?php echo $cl_messageError;?></span>
                        <?php endif; ?>

    </div> <!-- end col-sm-7 -->
</div> <!-- end form-group -->
    
<div class="form-actions">
       <button type="submit" class="btn btn-primary">Submit</button>
</div> <!-- end form-actions -->

</form>

</div> <!-- end splash -->

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

// Connect to database.
try {
    $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(Exception $e){
    die(var_dump($e));
}

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

// Code to for inserting registration into the database.
if ( !empty($_POST)) {
    // keep track validation errors
    $cl_taggerError = null;
    $cl_messageError = null;
         
    // keep track post values
    $cl_tagger = $_POST['cl_tagger'];
    $cl_message = $_POST['cl_message'];
         
    // validate input
    $valid = true;

    if (empty($cl_tagger)) {
        $cl_taggerError = 'Please enter your tagger name';
        $valid = false;
    }

    if (empty($cl_message)) {
        $cl_messageError = 'Please enter your message';
        $valid = false;
    }

    if($valid) {
        try {
            $cl_tagger = $_POST['cl_tagger'];
            $cl_message = $_POST['cl_message'];
    // Sanitize user input data size and strip HTML tags
            $tagger = strip_tags(substr($cl_tagger, 0, 30));
            $message = strip_tags(substr($cl_message, 0, 128));
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

        echo '<div class="row"><br><div class="col-xs-12 col-md-6 col-md-offset-3"><div class="alert alert-danger">';
        echo '   <span style="color: DarkRed;font-family: \'Gloria Hallelujah\';font-size: 30px;"><strong>You have tagged this wall!</strong>';
        echo '</div></div></div> <!-- end alert -->';
    } // end if valid

} // end if !empty

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
// Sanitize output for stripping HTML special characters
    $taggername = htmlspecialchars($tagname['tagger']);
    $taggermessage = htmlspecialchars($tagname['message']);
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
} //end if count
 
?>

</div> <!-- end container-fluid -->
</body>
</html>
