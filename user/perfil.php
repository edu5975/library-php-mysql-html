<?php    
    session_start();
    include "head.php";
    include "classPerfil.php";
      
    if(isset($_REQUEST['accion'])){
        if(isset($_POST['accion'])){
            switch ($_POST['accion']) {
                case 'perfil.update':
                    echo $oPerfil->accion("update");
                    break;                   
            }
        }
        else{
            switch ($_REQUEST['accion']) {
                
            }
        }
    }
    else{        
        echo $oPerfil->accion("formEdit");
    }
?>

