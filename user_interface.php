<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'>

<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='nl' lang='nl'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <meta name="description" content="Blog application by Esmeralda Tijhoff" />  
    <meta name="keywords" content="" />
    <meta name="author" content="A.E.Tijhoff" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
    <link href="./style.css"  media="all" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Pontano+Sans|Roboto+Mono" rel="stylesheet" />
   <title>Chatt App</title>
</head>
<body>


   <div id="container" class="container">
      <div class='titel' id="top-header">
        <h1>BLOG App</h1>
      </div>
      
    <!-- Main Menu -->
    <div class="mainmenu">
      <ul class="mainmenu">
        <li><a href="index.php">home</a></li>
        <li><a href="login.php">register</a></li>
        <li><a href="login.php">login</a></li>
        <li><a href="newblog.php">upload blog</a></li>
      </ul>
    </div>
    <br />
    <br />

<!-- connect to database MOVE TO INCLUDE PHP-->
<?php

// global scope
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "myblog"; 
// Connect to database global
$db = new PDO("mysql:host=$dbServername;dbname=$dbname;charset=utf8mb4", $dbUsername, $dbPassword);
  // set the PDO error mode to exception
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


//*************************************************************************//
// ***************  get information of blogger by user_ids  *************************************//
//*************************************************************************//


function getBlogger($user_id){
    global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
    $sql = "SELECT * FROM bloggers WHERE id= '$user_id'";
    foreach($db->query($sql) as $row) {
      $user_id = $row['id'];
      $username = $row['username'];
      $firstname = $row['firstname'];
      $lastname = $row['lastname'];
      $name = $firstname. " " .$lastname;
      $user_email = $row['email'];   

      echo "<h2>Welkom " .$name. " </h2>";
      echo "<table class='data'><tr><td>" .$user_email. "</td></tr>";
      echo "<tr><td><a href='./changeData.php'>Change Emailadress</a></td></tr>";
      echo "<tr><td><a href='./changeData.php'>Change Password</a></td></tr>";
      echo "</table>";


    }
  }



//*************************************************************************//
//*************************************************************************//
// ***************  Run the page!!!!!  ************************************//
//*************************************************************************//
//*************************************************************************//
try {
    
    // get blog by user_id
    getBlogger(1);
  }

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }





?>






</div>
</body>
</html>