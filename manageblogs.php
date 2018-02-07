<?php
session_start();  
 if(isset($_SESSION["login_user"]))  
 {  
  include_once ('include_phpfunctions.php');
  include_once ('include_html.php');
  

  if ( empty($_POST['submit']) || empty($_GET['cat']))
  {
      $user = $_SESSION['login_user'];
      echo '<h2>Welcome - '.$user.'</h2>';  
      // show titels of all blogs by user
      // include buttun to edit or delete specific blogs
      manageblogs($user);  

     // button to logout
      echo '<br /><br /><button><a href="logout.php">Logout</a></button>';    
  }

}  // if not logged in go to login page
 else  
 {  
      header("location:login.php");  
 }  

?>

    </div>
  </body>
</html>