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

      // get all blogs by user_id
      getUserId();

      ?>



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
// ERROR IF NO CONNECTION DATABASE
catch(PDOException $e)
    {
    echo "Connection failed";
    }

?>
