<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'>

<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='nl' lang='nl'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <meta name="description" content="Blog application by Esmeralda Tijhoff" />  
    <meta name="keywords" content="" />
    <meta name="author" content="A.E.Tijhoff" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Pontano+Sans|Roboto+Mono" rel="stylesheet">
   <title>Chatt App</title>
</head>
<body>


   <div id="container" class="container">
      <div class='titel' id="top-header">
        <h1>BLOG App</h1>
      </div>


<!-- connect to database MOVE TO INCLUDE PHP-->
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myblog";

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


//*************************************************************************//
//*************************************************************************//
// ***************  get all pages from one user_id ************************//
//*************************************************************************//


    echo "<table class='excerp'>";
    echo "<tr><th colspan='2'>Author: Esmoves</th></tr>";

    $user_id = "1";
    $sql = "SELECT * FROM blogs WHERE user_id=1";

   foreach($db->query($sql) as $row) {
    echo "<tr><td class='tekst'>";
    echo $row['excerp'].' </td><td>'.$row['id_categorie'] . '</td></tr>';
        }
        echo "</table>";
 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }


/*
$i;
while ($i=0, $i>$sgl['id'], $i++){
  echo "<tr><td>".$result["id_hoofdimg"]."</td><td>".$result["id_categorie"]." ".$result["tekst"]."</td></tr>";

*/



?>






</div>
</body>
</html>