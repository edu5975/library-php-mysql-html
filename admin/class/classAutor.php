<?php
    if(!class_exists("baseDatos"))
        include "../tools.php";

    class Autor extends baseDatos
    {
        function Autor(){

        }

        function accion($cual,$id=-1){
            $result="";
            switch ($cual) {
                case 'delete':
                    $this->consulta("delete from autor where id=".$id);
                    $result=$this->accion("list");//Refrescar la tabla
                    break;
                case 'list':
                    # Mostrar el listado de la tabla
                    $cad="select id, nombre, apellidos from autor";
                    //echo $cad;
                    $result=$this->showTabla($cad,true,array("edit","delete"),array("10%","40%","40%")); //Agregar fechaultAcceso, acceso, foto, para bd amorosos
                break;
                case 'insert':
                    $this->consulta("insert into autor set nombre='".$_POST['nombre']."', apellidos = '".$_POST['apellidos']."'");
                    $result=$this->accion("list"); //Refrescar la tabla
                break;
                case 'update':
                    $this->consulta("UPDATE autor set nombre='".$_POST['nombre']."', apellidos = '".$_POST['apellidos']."' WHERE id=".$_POST['id']);
                    $result=$this->accion("list"); 
                break;
    
                case 'formEdit':
                    $row=$this->saca_tupla("SELECT * from autor where id=".$_REQUEST['id']);    
    
                case 'formNew':
                    $result.='<div class="container">
                        <form method="post" >
                            <div class="form-group">
                                <label class="col-form-label" for="inputDefault" >Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="'.((isset($row->nombre))?$row->nombre:'').'" />
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="inputDefault" >Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" value="'.((isset($row->apellidos))?$row->apellidos:'').'" />
                            </div>';
                            $result.=(isset($row->nombre)?'<button class="btn btn-sm- btn-success">Actualizar</button><input type="hidden" name="id" value="'.$row->id.'"/><input type="hidden" name="accion" value="autor.update"     />':'<button class="btn btn-sm- btn-success">Registrar</button><input type="hidden" name="accion" value="autor.insert"     />');
                    $result.= '</form>
                    </div>';
                
                default:
                    # code...
                    break;
    
            }
            return $result;
        }

        function showTabla($query,$agregar = false,$p_iconos=array(),$p_columna=array(), $p_coloRenglon="table-dark"){
            $this->consulta($query);
            $result = '<div class="container"><span class="badge badge-primary">Autor</span><table class="table" border = "0">';
            #CABECERA DE LAS COLUMNAS
            $result.= '<tr class="bg-primary">';
            for ($coluC=0; $coluC < mysqli_num_fields($this->bloque); $coluC++) {   
                $campo = mysqli_fetch_field_direct($this->bloque,$coluC); 
                $result .= '<th class "table-info" '.((count($p_columna)>0)?' width='.$p_columna[$coluC]:' ').'>'.$campo->name.'</th>';
            }
            $result.='<td colspan = "'.count($p_iconos).'">'.(($agregar)?'<a href="?accion=autor.new"> 
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
                    $result.= '<td> <img style="cursor:pointer;" id="add"  width="5%"/> </td>';
                }
                if(in_array("delete",$p_iconos)){
                    $result.= '<td><a href="?id='.$id.'&accion=autor.delete"  width="5%"> <img style="cursor:pointer;" border="0" id="delete"/> </a></td>';
                }
                if(in_array("edit",$p_iconos)){
                    $result.= '<td><a href="?id='.$id.'&accion=autor.formEdit"  width="5%"> <img style="cursor:pointer;" border="0" id="edit"/> </a> </td>';
                }
                #FIN ICONOS DE ACCION
                $result.= '</tr> ';

            }
            $result.= '</table> </div>';
            return $result;
        }
    }
    
    $oAutor = new Autor();
?>