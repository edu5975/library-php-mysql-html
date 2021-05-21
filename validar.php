<body>
    <?php
        session_start();
        include "tools.php";
        $superAdmin=array("admin","control","edu5975");
        if(in_array($_POST['usr'],$superAdmin)){
            if($_POST['pwd'] == "12345"){
                $_SESSION['isAdmin']=true;
                header("location: admin/home.php");
            }
            
            else
                header("location: index.php?E=35");
        }
        else {
            $query = "select * from usuario where email ='".$_POST['usr']."' and clave= password('".$_POST['pwd']."')";
            $row = $BD->saca_tupla($query);
            if ($row) {
                if(date("Y-m-d") <= date($row->vencimiento) || 1 == 1) { 
                    $BD->consulta("UPDATE usuario set vencimiento = '".date("Y-m-d",strtotime(date("Y-m-d")."+ 1 month"))."' where id=".$row->id);                  
                    $_SESSION['nombre'] = $row->nombre." ".$row->apellidos;
                    $_SESSION['email'] = $row->email;
                    $_SESSION['id'] = $row->id;
                    $_SESSION['foto'] = $row->foto;
                    header("location: user/home.php");
                }
                else
                    header( "location: index.php?E=55");
            }
            else{
                header("location: index.php?E=1");
            }
        }
    ?>
</body>