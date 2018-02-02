<?php
session_start();  
 if(isset($_SESSION["login_user"]))  
 {  
   	include_once ('include_phpfunctions.php');
   	include_once ('include_html.php');

   	$user = $_SESSION['login_user'];
    echo '<h2>Welcome - '.$user.'</h2>';  
    userinterface($user);  

    echo '<br /><br /><button><a href="logout.php">Logout</a></button>';  
}  
 else  
 {  
      header("location:login.php");  
 }  

?>

		</div>
	</body>
</html>