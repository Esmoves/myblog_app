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
    // get blog by user_id
    $blog_id = $_GET['blog'];
    getOneBlogFromDB($blog_id);
   

    /* upload a comment form */
    ?>
    <form action="blog.php" method="post" name="comment" class="inputform">
    <label for="comment">Send us your comment</label><br>
    <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>" />
    <textarea class="excerp" type="text" name="comment"></textarea><br />
    <input type="submit" name="submit" value="send" /> 

    <?php
    
    getcomments($blog_id);
  }

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }





?>






</div>
</body>
</html>