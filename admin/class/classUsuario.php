<?php
    if(!class_exists("baseDatos"))
        include "../tools.php";

    class Usuario extends baseDatos
    {
        function Usuario(){

        }

        function accion($cual,$id=-1){
            $result="";
            switch ($cual) {
                case 'delete':
                    $this->consulta("delete from usuario where id=".$id);
                    $result=$this->accion("list");//Refrescar la tabla
                    break;
                case 'list':
                    # Mostrar el listado de la tabla
                    $cad="select id, nombre, apellidos, email from usuario";
                    //echo $cad;
                    $result=$this->showTabla($cad,true,array("edit","delete"),array("10%","20%","20%","40%")); //Agregar fechaultAcceso, acceso, foto, para bd amorosos
                break;
                case 'insert':
                    $this->consulta("insert into usuario set email='".$_POST['email']."',nombre='".$_POST['nombre']."',apellidos='".$_POST['apellidos']."',clave=password('".$_POST['clave']."'),fechIngreso='".date("Y-m-d")."'");
                    $result=$this->accion("list"); //Refrescar la tabla
                break;
                case 'update':
                    $this->consulta("update usuario set email='".$_POST['email']."',nombre='".$_POST['nombre']."',apellidos='".$_POST['apellidos']."',clave=password('".$_POST['clave']."'),vencimiento='".$_POST['vencimiento']."' WHERE id=".$_POST['id']);
                    $result=$this->accion("list"); //Refrescar la tabla
                break;
    
                case 'formEdit':
                    //$this-> consulta("select * from usuario where id="$id"");
                    $row=$this->saca_tupla("SELECT * from usuario where id=".$_REQUEST['id']); 
    
                case 'formNew':
                    $result.='<div class="container">
                        <form method="post" >
                            <div class="form-group">
                                <label class="col-form-label" for="inputDefault" >Nombre</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Nombre del usuario" value="'.((isset($row->nombre))?$row->nombre:'').'" id="inputDefault">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="inputDefault" >Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" placeholder="Apellidos del usuario" value="'.((isset($row->apellidos))?$row->apellidos:'').'" id="inputDefault">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="inputDefault" >Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email" id="inputDefault" value="'.((isset($row->email))?$row->email:'').'">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="inputDefault" >Clave</label>
                                <input type="password" class="form-control" name="clave" placeholder="" id="inputDefault" >
                            </div>
                            <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Vencimiento de cuenta</label>
                                    <input value="'.((isset($row->vencimiento))?$row->vencimiento:'').'" type="date" class="form-control" name="vencimiento" placeholder="Vencimiento" id="inputDefault">
                                </div>
                            <input type="hidden" name="accion" value="usuario.insert"/>'
                            .(isset($row->id)?'<button class="btn btn-sm- btn-success">Actualizar</button><input type="hidden" name="id" value="'.$row->id.'"/><input type="hidden" name="accion" value="usuario.update"     />':'<button class="btn btn-sm- btn-success">Registrar</button><input type="hidden" name="accion" value="usuario.insert"     />').
                        '</form>
                    </div>';
                
                default:
                    # code...
                    break;
    
            }
            return $result;
        }

        function showTabla($query,$agregar = false,$p_iconos=array(),$p_columna=array(), $p_coloRenglon="table-dark"){
            $this->consulta($query);
            $result = '<div class="container"><span class="badge badge-primary">Usuario</span><table class="table" border = "0">';
            #CABECERA DE LAS COLUMNAS
            $result.= '<tr class="bg-primary">';
            for ($coluC=0; $coluC < mysqli_num_fields($this->bloque); $coluC++) {   
                $campo = mysqli_fetch_field_direct($this->bloque,$coluC); 
                $result .= '<th class "table-info" '.((count($p_columna)>0)?' width='.$p_columna[$coluC]:' ').'>'.$campo->name.'</th>';
            }
            $result.='<td colspan = "'.count($p_iconos).'">'.(($agregar)?'<a href="?accion=usuario.new"> 
                <img id="add" width="1" height="1"/></a>':"&nbsp;").'</td>';

            $result.= '</tr>';

            for ($contR=0; $contR < $this->numeTuplas; $contR++) { 
                $result.= '<tr '.(($contR%2)?'class="'.$p_coloRenglon.'"':'').'>';                 
                                
                $tupla = mysqli_fetch_array($this->bloque);
                for ($coluC=0; $coluC < mysqli_num_fields($this->bloque); $coluC++) {    
                    $result.= '<td >'.$tupla[$coluC].' </td>';
                }
                #ICONOS DE ACCION
                $id = $tupla[0];
                if(in_array("ok",$p_iconos)){
                    $result.= '<td> <img style="cursor:pointer;" id="add" width="5%"/> </td>';
                }
                if(in_array("delete",$p_iconos)){
                    $result.= '<td><a href="?id='.$id.'&accion=usuario.delete"  width="5%"> <img style="cursor:pointer;" border="0" id="delete"/> </a></td>';
                }
                if(in_array("edit",$p_iconos)){
                    $result.= '<td><a href="?id='.$id.'&accion=usuario.formEdit"  width="5%"> <img style="cursor:pointer;" border="0" id="edit"/> </a> </td>';
                }
                #FIN ICONOS DE ACCION
                $result.= '</tr> ';

            }
            $result.= '</table> </div>';
            return $result;
        }
    }
    
    $oUsuario = new Usuario();
?>