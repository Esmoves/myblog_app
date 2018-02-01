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
//*************************** INDEX.php ***********************************//
// ***************  get ALL user_ids  *************************************//
// *************** run function get all blogs from DB ***********************//
//*************************************************************************//

function getUserId(){
global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
    $sql = "SELECT * FROM bloggers";
    foreach($db->query($sql) as $row){
      $user_id = $row['id'];
      $username = $row['username'];
         getAllBlogsFromDB($user_id, $username);
      }
}

//*************************************************************************//
//*************************** INDEX.php ***********************************//
// ***************  get all pages from one user_id ************************//
//*************************************************************************//

function getAllBlogsFromDB($user_id, $username){
 global $dbServername, $dbUsername, $dbPassword, $dbname, $db;

  $sql = "SELECT * FROM blogs WHERE user_id='$user_id' ORDER BY id DESC";
  foreach($db->query($sql) as $row) {
        $blog_id= $row['id'];
        $link = "<a href='./blog.php?blog=" .$blog_id. "''>";
        echo "<table class='excerp'>";
        echo "<tr><th colspan='1'>" . $link . $row['titel']. "</a><br />";
        echo "<em> By " .$username. "</em></th></tr>";
        // show image 
        echo "<tr><td>";
        echo "<img src='./user_images/" .$row['id_hoofdimg']. "' height='200px' />";
        echo "</td></tr>";
        echo "<tr><td class='tekst'>".$row['excerp']. "</td></tr>";
        echo "<tr><td class='category'><em>Category: ";
        
        getCategory($row['id']);

        echo "</em></td></tr>";
        echo "</table>";
    }
}

//*************************************************************************//
// ***************  get ONE BLOG from one user_id AND blog_id ************//
//*************************************************************************//

function getUserId_foroneblog(){
global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
    $sql = "SELECT * FROM bloggers";
    foreach($db->query($sql) as $row){
      $user_id = $row['id'];
      $username = $row['username'];
      $blog_id = $_GET['blog'];
       //  getOneBlogFromDB($user_id, $username, $blog_id);
      }
}

function getCategory($blog_id){
   global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
    $sql = "SELECT * FROM connectcatwithblog WHERE blog_id='$blog_id'";
    foreach($db->query($sql) as $row) {
      $cat_id = $row['categorie_id'];
      $sql2 = "SELECT * FROM categorie WHERE id='$cat_id'";
      foreach($db->query($sql2) as $row2) {
        $category = $row2['naam'];
        echo $category;
        echo " | ";
      }
    }
}

// ACTUAL CONTENT page blogger.php
function getOneBlogFromDB($blog_id){
 global $dbServername, $dbUsername, $dbPassword, $dbname, $db;

  $sql = "SELECT * FROM blogs WHERE id='$blog_id'";
  foreach($db->query($sql) as $row) {
        echo "<table class='excerp'>";
        echo "<tr><th colspan='1'>" .$row['titel']. "<br />";
        getBloggerbyBlogid($row['user_id']);
        echo "</th</tr>";
        echo "<tr><td class='category'>categories: ";
        getCategory($row['id']);
        echo "</td></tr>";
        // show image 
        echo "<tr><td>";
        echo "<img src='./user_images/" .$row['id_hoofdimg']. "' height='200px' />";
        echo "</td></tr>";
        // show text
        echo "<tr><td class='tekst'>" .$row['tekst']. "</td></tr>";  
        echo "</table>";
    }
}

function getBloggerbyBlogid($user_id){
  global $dbServername, $dbUsername, $dbPassword, $dbname, $db;

  $sql = "SELECT * FROM bloggers WHERE id='$user_id'";
  foreach($db->query($sql) as $row) {
    $username= $row['username'];
    echo "<em> By " .$username. "</em></th></tr>";
  }
}



//*************************************************************************//
//*********************   Leftmenu ****************************************//
// *************** Show the authors / Bloggers ****************************//
//*************************************************************************//
//*************************************************************************//

function showbloggers(){
 global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "SELECT * FROM bloggers";
  foreach($db->query($sql) as $row) {
        echo "<li>";
        echo "<a href='bloggers.php?blogger=" .$row['id']. "''>";
        echo $row['username'];
        echo "</a></li>";
    }
}


function showcategories(){
 global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "SELECT * FROM categorie";
  foreach($db->query($sql) as $row) {
        echo "<li>";
        echo "<a href='categories.php?cat=" .$row['id']. "''>";
        echo $row['naam'];
        echo "</a></li>";
    }
}



//*************************************************************************//
//*****************WELKOM BLOGGER  ****************************************//
// *************  get information of blogger by user_ids  *****************//
// *************  SHOW GEETING  *******************************************//
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
// *************  INSERT NEW BLOG INTO DATABASE upon POST  ****************//
//******** Call function categories to insert categories seperatly ********//
//*************************************************************************//
  function upload(){

    global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
    global $user_id;

    $titel= $_POST['titel'];
    $tekst= $_POST['tekst'];
    $id_hoofdimg = 10;
    $imgFile = $_FILES['image']['name'];
    $tmp_dir = $_FILES['image']['tmp_name'];
    $imgSize = $_FILES['image']['size']; 
    $excerp= $_POST['excerp'];
 //   $user_id = $_POST['user_id'];
    $user_id = 1;
    $dbh = new PDO("mysql:host=$dbServername;dbname=$dbname;charset=utf8mb4", $dbUsername, $dbPassword);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== added for upload purposes
  
    // handle the header img
    $upload_dir = 'user_images/'; // upload directory
    $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
    // valid image extensions
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
    // rename uploading image
    $userpic = rand(1000,1000000).".".$imgExt;
    // allow valid image file formats
    if(in_array($imgExt, $valid_extensions)){   
      // Check file size '5MB'
      if($imgSize < 5000000)    {
        move_uploaded_file($tmp_dir,$upload_dir.$userpic);
        }
      else{
       $errMSG = "Sorry, your file is too large.";
      }
     }
     else{
      $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";  
     }
    

    if(!isset($errMSG)){
      $sql = "INSERT INTO blogs ( user_id, titel, tekst, id_hoofdimg, excerp ) VALUES ( :user_id, :titel, :tekst, :id_hoofdimg, :excerp )";
      $query = $dbh->prepare( $sql );

      if ( $query->execute( array(':user_id'=>$user_id, ':titel'=>$titel, ':tekst'=>$tekst, ':id_hoofdimg'=>$userpic, ':excerp'=>$excerp ) ) )
      {
        $blog_id = $query->insert_id;  // find blog_id from the last upload
        // add the categories
        //uploadCat( $blog_id ); 
        echo "<script type= 'text/javascript'>alert('New Blog Inserted Successfully');</script>";
      }
      else{
        echo "<script type= 'text/javascript'>alert('Blog not successfully Inserted.');</script>";
       }
    }
  }

//*************************************************************************//
//********************* Upload categories seperatly ***********************//
//*************************************************************************//
function uploadCat( $blog_id ){
  global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  foreach ($_POST['category'] as $categorie_id)
    {  
      $sql2 = $db->prepare("INSERT INTO connectcatwithblog (`categorie_id`, `blog_id`) VALUES ( :categorie_id, :blog_id)");     
      $sql2->bindParam(':categorie_id', $categorie_id);
      $sql2->bindParam(':blog_id', $blog_id);
      $sql2->execute();
      print_r($sql2);
      echo "succes";
    }
    
  }



//*************************************************************************//
//*********************   Page categories **********************************//
// *************** Show the blogs of one categorie**************************//
//*************************************************************************//
//*************************************************************************//

function welcomecategory($categorie_id){
   global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "SELECT * FROM categorie WHERE id = $categorie_id";
  foreach($db->query($sql) as $row) {
        $categorie = $row['naam'];
        echo "<h2>All blogs with category: " .$categorie. "</h2>";
    }
  }

function showblogsbycategorie($categorie_id){
 global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "SELECT * FROM connectcatwithblog WHERE categorie_id = $categorie_id";
  foreach($db->query($sql) as $row) {
        $blog_id = $row['blog_id'];
          getOneBlogFromDB($blog_id);
    }
}



//*************************************************************************//
//*********************   Pages by BLOGGERS ********************************//
// *************** Show the blogs of one blogger  **************************//
//*************************************************************************//
//*************************************************************************//

function welcomeblogger($blogger_id){
   global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "SELECT * FROM bloggers WHERE id = $blogger_id";
  foreach($db->query($sql) as $row) {
        $blogger = $row['username'];
        $blogger_id= $row['id'];
        echo "<h2>All blogs by: " .$blogger. "</h2>";
    }
  }

function showblogsbyblogger($blogger_id){
 global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "SELECT * FROM blogs WHERE user_id = $blogger_id";
  foreach($db->query($sql) as $row) {
        echo "<table class='excerp'>";
        echo "<tr><th colspan='1'>" .$row['titel']. "<br />";
        echo "<tr><td class='category'>categories: ";
        getCategory($row['id']);
        echo "</td></tr>";
        echo "<tr><td class='tekst'>" .$row['tekst']. "</td></tr>";  
        echo "</table>";
    }
}


  ?>