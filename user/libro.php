<?php    
    session_start();
    if (!isset($_SESSION['id']))
        header("location: ../index.php?E=45");
        
    include "head.php";
    include "classLibro.php";   
       

    echo $oLibro->mostrar($_GET['id']);


?>