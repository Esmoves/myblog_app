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
http://localhost/websites/Myblogg_app/blog.php?action=delete&blog=48&comment=7
  // include html header
      // contains title, mainmenu, leftmenu
    include 'include_html.php';
    // get blog by user_id
    $blog_id = $_GET['blog'];
    getOneBlogFromDB($blog_id);

    if(isset($_SESSION["login_user"])) {

      // check if a comment is deleted
      if(!empty($_GET['action']) && !empty($_GET['comment'])){

        if($_GET['action'] == 'delete'){ 

          $comment_id= $_GET['comment'];
          deletecomment($comment_id);
        }
      } 

      // get user id 
      $username = $_SESSION['login_user'];
      $sql_user = "SELECT * FROM bloggers WHERE username = '$username'";
      foreach($db->query($sql_user) as $user){
        $user_id = $user['id'];
      }  
       // show edit blog button
      echo '<br /><br /><button><a href="editblog.php?action=edit&user=' .$user_id. '&blog=' .$blog_id. '">Edit this blog</a></button>';

      // show comments for blogger with delete option
      getcommentsfordelete($blog_id);

    }

    if(empty($_SESSION["login_user"])) {
      /* upload a comment form */
      ?>
      <form action="blog.php" method="post" name="comment" class="inputform">
      <label for="comment">Send us your comment</label><br>
      <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>" />
      <textarea class="excerp" type="text" name="comment"></textarea><br />
      <input type="submit" name="submit" value="send" /> 
      <?php     
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