<?php
// ERROR IF NO CONNECTION DATABASE
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }





?>