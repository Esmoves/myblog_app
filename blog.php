<?php
session_start();  
    include 'include_phpfunctions.php';


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
  }

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }





?>






</div>
</body>
</html>