<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'>

    <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='nl' lang='nl'>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <meta name="description" content="Blog application by Esmeralda Tijhoff" />  
        <meta name="keywords" content="" />
        <meta name="author" content="A.E.Tijhoff" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
        <link href="./style.css"  media="all" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Pontano+Sans|Roboto+Mono" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src='./scripts.js'></script>
        <script src='./scriptscat.js'></script>

       <title>Chatt App</title>

    </head>
    <body>


       <div id="container" class="container">
          <div class="titel" id="top-header">        

        <!-- Main Menu -->
        <div class="mainmenu">
          <ul class="mainmenu">
            <li><a href="index.php">home</a></li>
            <?php
            if(isset($_SESSION["login_user"]))  
            {  
              ?>
                <li><a href="user_interface.php">account</a></li>
                <li><a href="manageblogs.php">manage blogs</a></li>
                <li><a href="newblog.php">upload new blog</a></li>    
                <li><a href="logout.php">logout</a></li>
                <br /><br />
              <?php
            }
            else{
              ?><li><a href="login.php">login</a></li><?php
            }
            ?>
          </ul>
          <h1>BLOG App</h1>
        </div>  
      </div>
        <br />
        <br />

        <div class="Allcontent">
            <!-- Left side menu div -->
            <div class="leftmenu">
              <h3>Authors</h3>
              <ul class="lmenu">
                <?php
                  showbloggers();
                ?>
              </ul>
             <h3>Categories</h3>
             <ul id='myid' class="lmenu">
        
               <?php
               function showcategories(){             
                $db = new PDO("mysql:host=localhost;dbname=myblog;charset=utf8mb4", "root", "");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM categorie";
                foreach($db->query($sql) as $row) {
                      echo "<li id='" .$row['id']."' class='cat'><a href='#' >";
                     // echo "<a href='categories.php?cat=" .$row['id']. "''>";
                      echo $row['naam'];
                      echo "</a></li>";
                  }
                  unset($row);
              }

                  showcategories();
               ?>
               
                </ul>

              
            </div>
            <div class="maincontent" id="maincontent">
