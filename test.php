<?php
session_start();  

// global scope
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "myblog"; 
// Connect to database global
$db = new PDO("mysql:host=$dbServername;dbname=$dbname;charset=utf8mb4", $dbUsername, $dbPassword);
  // set the PDO error mode to exception
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);



//*************************************************************************//
// *************  INSERT NEW BLOG INTO DATABASE upon POST  ****************//
//******** Call function categories to insert categories seperatly ********//
//*************************************************************************//
  function upload(){

    global $dbServername, $dbUsername, $dbPassword, $dbname, $db;

    $titel= "titel";
    $tekst= "tekst";
    $excerp= "samenvatting";
 
    $username = $_SESSION['login_user'];
    $sql_user = "SELECT * FROM bloggers WHERE username = '$username'";
    foreach($db->query($sql_user) as $row){
      $user_id = $row['id'];
      return $user_id;
    }

    echo $user_id;
    die();
    $dbh = new PDO("mysql:host=$dbServername;dbname=$dbname;charset=utf8mb4", $dbUsername, $dbPassword);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== added for upload purposes

      $sql = "INSERT INTO blogs ( user_id, titel, tekst, id_hoofdimg, excerp ) VALUES ( :user_id, :titel, :tekst, :id_hoofdimg, :excerp )";
      $query = $dbh->prepare( $sql );

      if ( $query->execute( array(':user_id'=>$user_id, ':titel'=>$titel, ':tekst'=>$tekst, ':id_hoofdimg'=>$userpic, ':excerp'=>$excerp ) ) )
      {
        $blog_id = $query->insert_id;  // find blog_id from the last upload
        // add the categories
        uploadCat( $blog_id ); 
        echo "<script type= 'text/javascript'>alert('New Blog Inserted Successfully');</script>";
      }
      else{
        echo "<script type= 'text/javascript'>alert('Blog not successfully Inserted.');</script>";
       }
    }
  

//*************************************************************************//
//********************* Upload categories seperatly ***********************//
//*************************************************************************//
function uploadCat( $blog_id ){
  global $dbServername, $dbUsername, $dbPassword, $dbname, $db;
  foreach ($_POST['category'] as $categorie_id)
    {  
      $sql2 = $db->prepare("INSERT INTO connectcatwithblog (`categorie_id`, `blog_id`) VALUES ( :categorie_id, :blog_id)");     
      $sql2->bindParam(':categorie_id', $categorie_id);
      $sql2->bindParam(':blog_id', $blog_id);
      $sql2->execute();
      print_r($sql2);
      echo "succes";
    }  
  }

   if ( empty( $_POST['newblog'] ) ){ // if form is not send show form
    ?>
<form id="newblog" class="newblog" name="newblog" enctype="multipart/form-data" action="./test.php" method="post">
<label for="category">Choose your categories</label>
          <p style="font-size: 0.7em"><em>Keep CTRL pressed to select multiple categories</em></p>

          <!-- Get the categories out of the database to display in a multiple choice.
               You should be able to choose multiple categories-->
          <select  width="200" style="width: 200px" id="category" name="category[]" multiple> <!-- Initializing Name With An Array -->
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

        <input type="submit" id="newblog" name="newblog" class="btn" style="width:200px;" value="upload my blog!" />  

            <?php
    } else{ // if form is submitted, upload input to db
          upload();
          header("location:index.php");
      }