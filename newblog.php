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



<!-- connect to database MOVE TO INCLUDE PHP-->
<?php

// get username from login
$user_id = 1;

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
//*****************WELKOM BLOGGER  ****************************************//
// *************  get information of blogger by user_ids  *****************//
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

      echo "<h2>Upload a new blog as " .$name. " </h2>";

    }
  }



 //*************************************************************************//
    // *************  INSERT INTO DATABASE upon POST  *****************//
    //*************************************************************************//
  function upload(){

            global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
            global $user_id;

            $titel= $_POST['titel'];
            $tekst= $_POST['tekst'];
            $id_hoofdimg = 10;
            $id_categorie = 1;
            $excerp= $_POST['excerp'];
            
            $dbh = new PDO("mysql:host=$dbServername;dbname=$dbname;charset=utf8mb4", $dbUsername, $dbPassword);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== added for upload purposes
            
            $sql = "INSERT INTO blogs ( user_id, titel, tekst, id_hoofdimg, id_categorie, excerp ) VALUES ( :user_id, :titel, :tekst, :id_hoofdimg, :id_categorie, :excerp )";

            $query = $dbh->prepare( $sql );

            if ( $query->execute( array(':user_id'=>$user_id, ':titel'=>$titel, ':tekst'=>$tekst, ':id_hoofdimg'=>$id_hoofdimg, ':id_categorie'=>$id_categorie, ':excerp'=>$excerp ) )
            ){
              echo "<script type= 'text/javascript'>alert('New Blog Inserted Successfully');</script>";
            }
            
            else{
              echo "<script type= 'text/javascript'>alert('Blog not successfully Inserted.');</script>";
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

   

    if ( empty( $_POST ) ){ // if form is not send show form
    ?>

        <form id="newblog" class="newblog" name="newblog" action="./newblog.php" method="post">
        <label for"titel">Titel</label><br />
        <input type="text" name="titel" id="titel" required="required" placeholder="Please Enter your titel" /><br /><br />

        <label for"excerp">Excerp</label><br />
        <textarea id="excerp" class="excerp" name="excerp" required="required"></textarea><br /><br />
        <label for"tekst">Text</label><br />
        <textarea id="tekst" name="tekst" required="required"></textarea><br /><br />
        <input type="submit" id="newblog" class="btn">  
          
    <?php
    } else{ // if form is submitted, upload input to db

            upload();
            header("location:index.php");
      }




    }

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }





?>






</div>
</body>
</html>