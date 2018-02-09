<?php
session_start();  
    include 'include_phpfunctions.php';

if(!empty($_POST['submit'])){
  insertcomment();
}

//*************************************************************************//
//*************************************************************************//
// ***************  Run the page!!!!!  ************************************//
//*************************************************************************//
//*************************************************************************//
try {

    // include html header
    // contains title, mainmenu, leftmenu
    include 'include_html.php';
    $blog_id = $_GET['blog'];

    $blogger = getusername($blog_id);

 if(isset($_SESSION["login_user"])){
    if($_SESSION["login_user"] == $blogger ){
        
      // check if a comment is deleted
      if(!empty($_GET['action']) ){
        if($_GET['action'] == 'delete' && !empty($_GET['comment'])){ 
          $comment_id= $_GET['comment'];
          deletecomment($comment_id);
        }
        if($_GET['action'] == 'close' && !empty($_GET['blog'])){ 
          $blog_id= $_GET['blog'];
          closeblog($blog_id);
        } 
      }
    
      // get user_id
      $username = $_SESSION['login_user'];
      $sql_user = "SELECT * FROM bloggers WHERE username = '$username'";
      foreach($db->query($sql_user) as $user){
        $user_id = $user['id'];
      }
       // show edit blog button
      echo '<br /><br /><button style="width:500px;"><a href="editblog.php?action=edit&user=' .$user_id. '&blog=' .$blog_id. '">Edit this blog</a></button>';

      echo '<br /><br /><button style="width:500px;"><a href="blog.php?action=close&blog=' .$blog_id. '">Close this blog for commenting</a></button>';

      // show comments for blogger with delete option
      getcommentsfordelete($blog_id);

       // get blog by user_id
      getOneBlogFromDB($blog_id);
    }
    else{

      // get blog by user_id
      getOneBlogFromDB($blog_id);

      // show comments for reader
      getcomments($blog_id);
    }
      
  }
    // else if visiter is reader or other blogger
    else {

      // get blog by user_id
      getOneBlogFromDB($blog_id);

      // show comments for reader
      getcomments($blog_id);
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
