<?php
session_start();  
 if(isset($_SESSION["login_user"])){

  include_once ('include_phpfunctions.php');
  include_once ('include_html.php');

   if ( empty( $_POST['newblog'] ) ){ // if form is not send show form
        
        // get user_id
        $username = $_SESSION['login_user'];
        $sql_user = "SELECT * FROM bloggers WHERE username = '$username'";
        foreach($db->query($sql_user) as $row){
          $user_id = $row['id'];
          getBlogger($user_id);
    //     echo "<h2>Upload as " .$name. " </h2>";
        }    

        

    ?>
        <form id="newblog" class="newblog" name="newblog" enctype="multipart/form-data" action="./newblog.php" method="post">
        <label for"titel">Titel</label><br />
        <input type="text" name="titel" id="titel" required="required" placeholder="Please Enter your titel" /><br /><br />
        
        <label for"headerimg">Header image</label><br />
        <input name="image" type="file" accept="image/*"><br /><br />
       
        <label for"excerp">Excerp</label><br />
        <textarea id="excerp" class="excerp" name="excerp" required="required"></textarea><br /><br />
        <label for"tekst">Text</label><br />
        <textarea id="tekst" name="tekst" required="required"></textarea><br /><br />
       <div style="margin-left: 100px;">
          <label for="category">Choose your categories</label>
       <!--   <p style="font-size: 0.7em"><em>Keep CTRL pressed to select multiple categories</em></p> 
       -->

          <!-- Get the categories out of the database to display in a multiple choice.
               You should be able to choose multiple categories-->
          <select  width="200" style="width: 200px" id="category" name="category"> <!-- <select  width="200" style="width: 200px" id="category" name="category[]" multiple> Initializing Name With An Array -->
            <?php
                global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
                $sql = "SELECT * FROM categorie";
                foreach($db->query($sql) as $row)
                {  
                  $id= $row['id'];
                  $naam = $row['naam'];
                  echo "<option name='category' id='category' style='text-align: center;' value='".$id."'>" . $naam . "</option>";
                } 
            ?>
          </select><br /><br />

        <input type="submit" id="submitnewblog" name="newblog" style="width:200px;" value="upload my blog!" />  
      </div>   

    </div> <!-- end container -->
  </body>
 <script src="scripts.js"></script>
</html> 

    <?php
    } 
    else if ( !empty( $_POST['newblog'] ) ){ // if form is submitted, upload input to db
         
         
         
          upload();
    }

} // end session
else{
  header("location:login.php");
}
    
?>