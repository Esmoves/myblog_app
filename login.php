<?php
session_start();  

    include_once ('include_phpfunctions.php');
    
    include_once ('user.php');

     if ( isset( $_POST['submit'] ) ){ // if form is not send show form
     	$username = $_POST['username'];
     	$password = $_POST['password'];

     	$object = new User();
     	$object->Login($username, $password);
     	// varification error already done in user.php
 		$_SESSION['login_user']=$username; // Initializing Session
 		header("location:user_interface.php");
	}
	else{ // if form not submitted show form

		// include html header  
      	include_once ('include_html.php');
     ?>
 		<form name="login" id="login" method="POST" action="login.php">
     		<label for"username">Username</label><br />
     		<input type="text" name="username"><br /><br />
     		<label for="password">Password</label><br />
     		<input type="password" name="password"><br /><br />
     		<input type="submit" name="submit" value="submit">
     	</form>

   <!--- FOOTER  -->   
          </div> <!-- end div main content -->
        </div> <!-- end div all content -->

      <!-- validated CSS SIGN -->
      <div class="footer">
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img style="border:0;width:88px;height:31px"
        src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
        alt="Valide CSS!" />
        </a>
        </p>
      </div>

    </div> <!-- end container div -->
  </body>
</html>
<?php
}
?>