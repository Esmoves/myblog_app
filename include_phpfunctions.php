<!-- connect to database MOVE TO INCLUDE PHP-->
<?php


// ******************************************************************//
//*************************** General functions *********************//
//*******************************************************************//

function getuserid(){
    // get user_id
    $username = $_SESSION['login_user'];
    $sql_user = "SELECT * FROM bloggers WHERE username = '$username'";
    foreach($db->query($sql_user) as $user){
      $user_id = $user['id'];
    }  
}



//*************************************************************************//
//*********************   Leftmenu ****************************************//
// *************** SELECT ON authors **************************************//
//*************************************************************************//
//*************************************************************************//

// left MENU BUTTONS:
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

// *************** Show the blogs of one blogger  **************************//
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
//*********************   Leftmenu ****************************************//
// *************** SELECT ON CATEGORY *************************************//
//*************************************************************************//
//*************************************************************************//

// left MENU BUTTONS:
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

// *************** Show the blogs of one categorie**************************//
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
  $sql = "SELECT blogs.id AS blog_id, categorie.id FROM blogs
  INNER JOIN categorie 
  ON blogs.category = categorie.id
  WHERE categorie.id = '$categorie_id'
  ORDER BY blogs.id DESC";

  foreach($db->query($sql) as $row) {
        $blog_id = $row['blog_id'];
          getOneBlogFromDB($blog_id);
    }
    unset($row);
}



//*************************************************************************//
//*************************** INDEX.php ***********************************//
// ***************  get all blogs sorted on newest first ******************//
//*************************************************************************//

function getAllBlogsFromDB(){
 global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "SELECT *, blogs.id AS bid 
  FROM blogs
  INNER JOIN bloggers
  ON blogs.user_id = bloggers.id
  ORDER BY blogs.id DESC";
  foreach($db->query($sql) as $row) {
     if (!empty($row)){
        $blog_id= $row['bid'];
        $link = "<a href='./blog.php?blog=" .$blog_id. "'>";
        echo "<table class='excerp'>";
        echo "<tr><th colspan='1'>" . $link . $row['titel']. "</a><br />";
        echo "<em> By " .$row['username']. "</em></th></tr>";

        if(!empty($row['id_hoofdimg'])){
          // show image 
          echo "<tr><td>";
          echo "<img src='./user_images/" .$row['id_hoofdimg']. "' height='200px' />";
          echo "</td></tr>";
        }

        echo "<tr><td class='tekst'>" . $link . $row['excerp']. "</a></td></tr>";
        echo "<tr><td class='category'><em>Category: ";
        
        getCategory($row['category']);

        echo "</em></td></tr>";
        echo "</table>";
      }
      else { 
        echo "<p>Nothing to show.</p>";
      }
    }
    unset($row);
}

//*************************************************************************//
// ***************  get ONE BLOG from one user_id AND blog_id ************//
//************************* SHOW THE CATEGORY ****************************//
//************************* SHOW THE COMMENTS ****************************//
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

function getCategory($category){
   global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
    $sql = "SELECT * FROM categorie WHERE id='$category'";
    foreach($db->query($sql) as $row) {
      $category = $row['naam'];
      echo $category;
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
        getCategory($row['category']);
        echo "</td></tr>";

        if(!empty($row['id_hoofdimg'])){
          // show image 
          echo "<tr><td>";
          echo "<img src='./user_images/" .$row['id_hoofdimg']. "' height='200px' />";
          echo "</td></tr>";
        }

        // show text
        echo "<tr><td class='tekst'>" .$row['tekst']. "</td></tr>";  
        echo "</table>";
    }
    unset($row);
}

//*************************************************************************//
// ***************  SHOW AND MANAGE COMMENTS *****************************//
//******************************************* ****************************//
//*************************************************************************//

// INSERT a new comment to the DB
function insertcomment(){
   global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
   $comment = htmlspecialchars($_POST['comment']);
   $blog_id = $_POST['blog_id'];

   $sql = "INSERT INTO comments ( blog_id, comment ) VALUES ( :blog_id, :comment)";
   $query = $db->prepare( $sql );
   $query->execute( array( ':blog_id'=>$blog_id, ':comment'=>$comment )); 

   header('location:blog.php?blog='.$blog_id.'');

}


// get the comments of the blog
  function getcomments($blog_id){
    global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
    echo "<table class='comments'>";
    echo "<tr><th colspan='1'>Comments</th></tr>";
    
    $sql="SELECT c.comment
    FROM comments c
    INNER JOIN blogs b 
    ON b.id = c.blog_id
    WHERE b.id= '$blog_id'
    AND c.deleted = 'false'";    
    foreach($db->query($sql) as $row) {
        echo "<tr><td>" .$row['comment']. "</td></tr>";
      }
      echo "</table>";
      unset($row);
  }


// get the comments of the blog with option to to delete them
  function getcommentsfordelete($blog_id){
    global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
    echo "<table class='comments'>";
    echo "<tr><th colspan='2'>Comments</th></tr>";
    
    $sql="SELECT c.id AS comment_id, c.comment
    FROM comments c
    INNER JOIN blogs b 
    ON b.id = c.blog_id
    WHERE b.id= '$blog_id'
    AND c.deleted = 'false'";  
    foreach($db->query($sql) as $row) {
        echo "<tr><td>" .$row['comment']. "</td>";
        echo "<td><a href='blog.php?action=delete&blog=".$blog_id. "&comment=" .$row['comment_id']. "'>";
        echo "delete</a></td></tr>"; 
      }
      echo "</table>";
      unset($row);
  } 

// delete the comment
  function deletecomment($comment_id){
    global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
    $sql = "UPDATE comments SET deleted=true WHERE id = '$comment_id'";
    $stmt = $db->prepare($sql);
    if ($stmt->execute()){        
          echo "<script>alert('Comment deleted!')</script>";     
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
      return $name;
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
    $excerp= $_POST['excerp'];
    $category= $_POST['category'];

    getuserid(); 

    // if illustration is given, upload img   
    if(!empty($_FILES['image']['name'])){
      $imgFile = $_FILES['image']['name'];
      $tmp_dir = $_FILES['image']['tmp_name'];
      $imgSize = $_FILES['image']['size']; 

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
         echo "<script type= 'text/javascript'>alert('Sorry, your file is too large.');</script>";
        }
       }
       else{
        echo "<script type= 'text/javascript'>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>"; 
       }
      }
      else $userpic = "NULL";
   
      // start the actual upload section
      $sql = "INSERT INTO blogs ( user_id, titel, tekst, id_hoofdimg, excerp, category ) VALUES ( :user_id, :titel, :tekst, :id_hoofdimg, :excerp, :category)";
      $query = $db->prepare( $sql );
      if( $query->execute( array(':user_id'=>$user_id, ':titel'=>$titel, ':tekst'=>$tekst, ':id_hoofdimg'=>$userpic, ':excerp'=>$excerp, 'category'=>$category ) ) )
        {   
          echo "<script type= 'text/javascript'>alert('New Blog Inserted Successfully');</script>";
          header('location: user_interface.php');
      }
      else{
        echo "<script type= 'text/javascript'>alert('Blog not successfully Inserted.');</script>";
       }
    }


//*************************************************************************//
//************************ USER PAGE **************************************//
//*************************************************************************//

    
 function usersettings($user){ 
  global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "SELECT * FROM bloggers WHERE username = '$user'";
  //// return first row
  $sth = $db->prepare($sql);
  $sth->execute();
  $row = $sth->fetch(PDO::FETCH_ASSOC);

    echo "<table class='excerp'>";
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $email = $row['email'];
    echo "<table class='excerp'><tr><th colspan='2'>Settings user</th></tr>";
    echo "<tr><td>Name</td><td>" .$firstname. " " .$lastname. "</td></tr>";
    echo "<tr><td>Email</td><td>" .$email. "</td></tr>";
    echo "</table>";
    unset($row);
}

// show all blogs with options to edit or delete blogs//
// show if blog has comments //
function manageblogs($user){
  global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  echo "<table class='excerp'>";
  echo "<th colspan='4'>Manage your blogs</th>";
  $sql = "
  SELECT *, b.id AS bid 
  FROM blogs b
  INNER JOIN bloggers a 
  ON b.user_id = a.id 
  WHERE a.username = '$user'
  ORDER BY b.id DESC";
  $db->query($sql);
  foreach($db->query($sql) as $row) {
        $blog_id= $row['bid'];
        $link = "<a href='./blog.php?blog=" .$blog_id. "''>";
        echo "<tr><td>" . $link . $row['titel']. "</a></td>";
        echo "<td><a href='./editblog.php?action=edit&user=" .$row['user_id']. "&blog=" .$blog_id. "'>edit</a></td>";
        echo "<td><a href='./editblog.php?action=delete&user=" .$row['user_id']. "&blog=" .$blog_id. "'>delete</a></td>";
        echo "<td><a href='./blog.php?blog=" .$blog_id. "'>Comments</a></td>";
        echo "</tr>";
        }
        echo "</table>";
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


 function managecategories(){
   global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
   $sql = "SELECT * FROM categorie";
   echo "<table class='excerp'><tr><th colspan='2'>Categories</th></tr>";
   foreach($db->query($sql) as $row) {
      $categorie = $row['naam'];
      $categorie_id = $row['id'];
      $link = "<a href='./user_interface.php?cat=" .$categorie_id. "'>";
      
      echo "<tr><td>" .$categorie. "</td>";
      echo "<td>" .$link. "delete</a></td>";
      echo "</tr>";
      
    }
    echo "</table>";  
    unset($row);
  }

function deletecat($cat_id){
  global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "DELETE FROM categorie WHERE id = '$cat_id'";
  $stmt = $db->prepare($sql);
  if ($stmt->execute()){
      header('location:user_interface.php');
    }
 }

 function insertnewcat($newcatname){
  global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  $sql = "INSERT INTO categorie (naam) VALUES ( :naam )";
  $query = $db->prepare( $sql );
  if( $query->execute( array(':naam'=>$newcatname ) ) ){
     header('location:user_interface.php');
  }
 }

  ?>