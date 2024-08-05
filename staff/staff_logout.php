<?php 
   session_start();
   
   session_unset();
   echo '<script type="text/javascript">
                        alert("Berjaya keluar.")
                        </script>';
    echo "<meta http-equiv=\"refresh\" content=\"0;URL= ..\home.php\">";
   //header("Location:../home.php");


 ?>