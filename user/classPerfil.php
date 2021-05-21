<?php
    if(!class_exists("baseDatos"))
        include "../tools.php";

    class Perfil extends baseDatos
    {
        function Perfil(){

        }

        function accion($cual,$id=-1){
            $result="";
            switch ($cual) {
                case 'delete':
                    $this->consulta("delete from usuario where id=".$id);
                    $result=$this->accion("list");//Refrescar la tabla
                    break;
                case 'update':
                    if($_POST['clave']==$_POST['clave2']){
                        if ($_POST['clave']!="") {
                            $photo="";
                            if (isset($_FILES['archFoto']['name'])&& $_FILES['archFoto']['name']>"") {
                                $arreDatos=explode(".", $_FILES['archFoto']['name']);
                                $photo=$_SESSION['id'].".".$arreDatos[count($arreDatos)-1];
                                move_uploaded_file($_FILES['archFoto']['tmp_name'], "../src/usuarios/".$photo);
                                $_SESSION['foto']=$photo;
                            }
                            $this->consulta("UPDATE usuario set nombre='".$_POST['nombre']."', ".($photo!=""?"foto = '".$photo."',":"")." apellidos = '".$_POST['apellidos']."' , nacimiento = '".$_POST['nacimiento']."', genero = '".$_POST['genero']."', clave = password('".$_POST['clave']."')  WHERE id=".$_SESSION['id']);
                            header("location: perfil.php");
                        }
                        else{                            
                            echo 'Ingrese una clave para poder actualizar los datos';                        
                            $result=$this->accion("formEdit"); 
                        }
                    }
                    else{
                        echo 'Las contraseñas no coinciden';                        
                        $result=$this->accion("formEdit"); 
                    }
                break;
    
                case 'formEdit':                    
                    $query = "select nombre, apellidos, email, nacimiento, clave, vencimiento, genero from usuario where id=".$_SESSION['id'];
                    $this->consulta($query);
                    $tupla = mysqli_fetch_array($this->bloque);
                    #echo $tupla['id'];
                    $result.='<div class="container-fluid">
                    <form method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Nombre</label>
                                    <input value= '.$tupla['nombre'].' type="text" class="form-control" name="nombre" placeholder="Nombre del usuario" id="inputDefault">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Apellidos</label>
                                    <input value= '.$tupla['apellidos'].'  type="text" class="form-control" name="apellidos" placeholder="Apellidos del usuario" id="inputDefault">
                                </div>                                
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Nacimiento</label>
                                    <input value= "'.$tupla['nacimiento'].'" type="date" class="form-control" name="nacimiento" placeholder="Vencimiento" id="inputDefault">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Vencimiento de cuenta</label>
                                    <input value= '.$tupla['vencimiento'].' title = "Si no accedes a tu cuenta antes de la fecha de vencimiento de deshabilitara y deberas contactar un administrador para poder acceder nuevamente" disabled="disabled" type="date" class="form-control" name="vencimiento" placeholder="Vencimiento" id="inputDefault">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Email</label>
                                    <input  disabled="disabled" title="Para cambiar el correo contacte con el administrador" value= "'.$tupla['email'].'"  type="text" class="form-control" name="email" placeholder="email" id="inputDefault">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Sexo</label>
                                    <select class="form-control" name="genero" id="genero" >
                                        <option '.($tupla['genero']=='M'?'selected':'').' value="M" >Masculino</option>
                                        <option '.($tupla['genero']=='F'?'selected':'').' value="F" >Femenino</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Foto</label>
                                    <input  type="file" accept="image/*" class="form-control" name="archFoto" placeholder="" id="inputDefault"/>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Clave</label>
                                    <input type="password" class="form-control" name="clave" placeholder="" id="inputDefault">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Confirmación de Clave</label>
                                    <input type="password" class="form-control" name="clave2" placeholder="" id="inputDefault">
                                </div>
                            </div>
                        </div>                  
                        
                        <input type="hidden" name="accion" value="perfil.update" />        
                        <button onclick="regresarMensajeActualizar()" type="submit" class="btn btn-primary" >Actualizar</button>
                    </form>
                </div>';
                default:
                   
                    break;
    
            }
            return $result;
        }
    }
    
    $oPerfil = new Perfil();
?>

