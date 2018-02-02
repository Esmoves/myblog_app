<!-- connect to database MOVE TO INCLUDE PHP-->
<?php

// global scope
$dbServername = "localhost";
$dbUsername = "root";
//$dbUsername = "tomklru270_esmo";
$dbPassword="";
//$dbPassword = "flapperdeflap";
$dbname = "myblog"; 
//$dbname = "tomklru270_blogesmo";
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
      unset($row);
}

//*************************************************************************//
//*************************** INDEX.php ***********************************//
// ***************  get all blogs by user_id sorted on newest first *******//
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

        echo "<tr><td class='tekst'>" . $link . $row['excerp']. "</a></td></tr>";
        echo "<tr><td class='category'><em>Category: ";
        
        getCategory($row['id']);

        echo "</em></td></tr>";
        echo "</table>";
    }
    unset($row);
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
      unset($row);
}

function getBloggerbyBlogid($user_id){
  global $dbServername, $dbUsername, $dbPassword, $dbname, $db;

  $sql = "SELECT * FROM bloggers WHERE id='$user_id'";
  foreach($db->query($sql) as $row) {
    $username= $row['username'];
    echo "<em> By " .$username. "</em></th></tr>";
  }
  unset($row);
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
      unset($row2);
    }
    unset($row);
}

// Get the actual blog
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
    unset($row);
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
    unset($row);
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
    unset($row);
}



//*************************************************************************//
//*****************WELKOM BLOGGER  ****************************************//
// *************  get information of blogger by user_ids  *****************//
// *************  SHOW GEETING  *******************************************//
//*************************************************************************//

function getBlogger($user_id){
    global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
    $sql = "SELECT * FROM bloggers WHERE id= '$user_id'";

    //// return first row
    $sth = $db->prepare($sql);
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_ASSOC);

    ////

    // foreach($db->query($sql) as $row) {
      $user_id = $row['id'];
      $username = $row['username'];
      $firstname = $row['firstname'];
      $lastname = $row['lastname'];
      $name = $firstname. " " .$lastname;
      $user_email = $row['email'];   

      echo "<h2>Upload as " .$name. " </h2>";
    }


//*************************************************************************//
// *************  INSERT NEW BLOG INTO DATABASE upon POST  ****************//
//******** Call function categories to insert categories seperatly ********//
//*************************************************************************//
  function upload(){

    global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== added for upload purposes
    $titel= $_POST['titel'];
    $tekst= $_POST['tekst'];
    $imgFile = $_FILES['image']['name'];
    $tmp_dir = $_FILES['image']['tmp_name'];
    $imgSize = $_FILES['image']['size']; 
    $excerp= $_POST['excerp'];

    // get user_id
  /*  $username = $_SESSION['login_user'];
    $sql_user = "SELECT * FROM bloggers WHERE username = '$username'";
    foreach($db->query($sql_user) as $user){
      $user_id = $user['id'];
      return $user_id;
    } 
    */
    $user_id='2';   

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
      $query = $db->prepare( $sql );
      $query->execute( array(':user_id'=>$user_id, ':titel'=>$titel, ':tekst'=>$tekst, ':id_hoofdimg'=>$userpic, ':excerp'=>$excerp ) );
     
   /*  $blog_id = $db->lastInsertId();  // find blog_id from the last upload

      $array = $_POST['category']; // unpack the array from post category
          // print_r($category);  geeft Array ( [0] => 1 [1] => 2 [2] => 4 )
          for ($i = 0; $i < count($array); $i++) {
            $categorie_id = $array[$i];
            $sql2 = "INSERT INTO connectcatwithblog ('categorie_id', 'blog_id') 
                VALUES ('$categorie_id', '$blog_id')";
            $query2 = $db->prepare($sql2); 
            $query2->execute();

          }
*/
        echo "<script type= 'text/javascript'>alert('New Blog Inserted Successfully');</script>";
        header('location: user_interface.php');
      }
      else{
        echo "<script type= 'text/javascript'>alert('Blog not successfully Inserted.');</script>";
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
    unset($row);
  }

function showblogsbycategorie($categorie_id){
 global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "SELECT * FROM connectcatwithblog WHERE categorie_id = $categorie_id ORDER BY blog_id DESC";
  foreach($db->query($sql) as $row) {
        $blog_id = $row['blog_id'];
          getOneBlogFromDB($blog_id);
    }
    unset($row);
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
    unset($row);
  }

function showblogsbyblogger($blogger_id){
 global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "SELECT * FROM blogs WHERE user_id = $blogger_id ORDER BY id DESC";
  foreach($db->query($sql) as $row) {
        $blog_id= $row['id'];
        $link = "<a href='./blog.php?blog=" .$blog_id. "''>";
        echo "<table class='excerp'>";
        echo "<tr><th colspan='1'>" . $link . $row['titel']. "</a><br />";
        echo "</th></tr>";
        // show image 
        echo "<tr><td>";
        echo "<img src='./user_images/" .$row['id_hoofdimg']. "' height='200px' />";
        echo "</td></tr>";

        echo "<tr><td class='tekst'>" . $link . $row['excerp']. "</a></td></tr>";
        echo "<tr><td class='category'><em>Category: ";
        
        getCategory($row['id']);

        echo "</em></td></tr>";
        echo "</table>";
    }
    unset($row);
}

//*************************************************************************//
//************************ USER PAGE **************************************//
//*************************************************************************//

// show all blogs with uptions to edit or delete //
function userinterface($user){
  global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  echo "<table class='excerp'>";
  echo "<th colspan='3'>Manage your blogs</th>";

  $sql = "
  SELECT * 
  FROM bloggers a, blogs b 
  WHERE a.id = b.user_id AND a.username = '$user'";
  $db->query($sql);
  foreach($db->query($sql) as $row) {
    $blog_id= $row['id'];
    $link = "<a href='./blog.php?blog=" .$blog_id. "''>";
    echo "<tr><td>" . $link . $row['titel']. "</a></td>";
    echo "<td><a href='./editblog.php?action=edit&user=" .$row['user_id']. "&blog=" .$blog_id. "''>edit</a></td>";
    echo "<td><a href='./editblog.php?action=delete&user=" .$row['user_id']. "&blog=" .$blog_id. "''>delete</a></td>";
    echo "</tr>";
    }
    echo "</table>";

    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $email = $row['email'];
    echo "<table class='excerp'><tr><th colspan='2'>Settings user</th></tr>";
    echo "<tr><td>Name</td><td>" .$firstname. " " .$lastname. "</td></tr>";
    echo "<tr><td>Email</td><td>" .$email. "</td></tr>";
    echo "</table>";

    unset($row);
  }


// Edit a blog //
function editmyblog($blog_id){
    global $dbServername, $dbUsername, $dbPassword, $dbname, $db;

    $titel= $_POST['titel'];
    $tekst= $_POST['tekst'];
    $imgFile = $_FILES['image']['name'];
    $tmp_dir = $_FILES['image']['tmp_name'];
    $imgSize = $_FILES['image']['size']; 
    $excerp= $_POST['excerp'];
    
    $dbh = new PDO("mysql:host=$dbServername;dbname=$dbname;charset=utf8mb4", $dbUsername, $dbPassword);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== added for upload purposes
  
    $sql = "UPDATE blogs 
    SET titel='$titel', tekst='$tekst', excerp= '$excerp'
    WHERE id = '$blog_id'";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    echo $stmt->rowCount() . " records UPDATED successfully";
    }

// Delete a blog //
function deleteblog($blog_id){
  global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "DELETE FROM blogs WHERE id = '$blog_id'";
  $stmt = $db->prepare($sql);
  $stmt->execute();
}

  ?>