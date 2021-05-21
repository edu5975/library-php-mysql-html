<?php
    if(!class_exists("baseDatos"))
        include "../tools.php";

    class Categoria extends baseDatos
    {
        function Categoria(){

        }

        function accion($cual,$id=-1){
            $result="";
            switch ($cual) {
                case 'delete':
                    $this->consulta("delete from categoria where id=".$id);
                    $result=$this->accion("list");//Refrescar la tabla
                    break;
                case 'list':
                    # Mostrar el listado de la tabla
                    $cad="select id, nombre from categoria";
                    //echo $cad;
                    $result=$this->showTabla($cad,true,array("edit","delete"),array("10%","80%")); //Agregar fechaultAcceso, acceso, foto, para bd amorosos
                break;
                case 'insert':
                    $this->consulta("insert into categoria set nombre='".$_POST['nombre']."'");
                    $result=$this->accion("list"); //Refrescar la tabla
                break;
                case 'update':
                    $this->consulta("UPDATE categoria set nombre='".$_POST['nombre']."' WHERE id=".$_POST['id']);
                    $result=$this->accion("list"); 
                break;
    
                case 'formEdit':
                    $row=$this->saca_tupla("SELECT * from categoria where id=".$_REQUEST['id']);    
    
                case 'formNew':
                    $result.='<div class="container">
                        <form method="post" >
                            <div class="form-group">
                                <label class="col-form-label" for="inputDefault" >Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="'.((isset($row->nombre))?$row->nombre:'').'" />
                            </div>';
                            $result.=(isset($row->nombre)?'<button class="btn btn-sm- btn-success">Actualizar</button><input type="hidden" name="id" value="'.$row->id.'"/><input type="hidden" name="accion" value="categoria.update"     />':'<button class="btn btn-sm- btn-success">Registrar</button><input type="hidden" name="accion" value="categoria.insert"     />');
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
            $result = '<div class="container"><span class="badge badge-primary">Categoria</span><table class="table" border = "0">';
            #CABECERA DE LAS COLUMNAS
            $result.= '<tr class="bg-primary">';
            for ($coluC=0; $coluC < mysqli_num_fields($this->bloque); $coluC++) {   
                $campo = mysqli_fetch_field_direct($this->bloque,$coluC); 
                $result .= '<th class "table-info" '.((count($p_columna)>0)?' width='.$p_columna[$coluC]:' ').'>'.$campo->name.'</th>';
            }
            $result.='<td colspan = "'.count($p_iconos).'">'.(($agregar)?'<a href="?accion=categoria.new"> 
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
                    $result.= '<td><a href="?id='.$id.'&accion=categoria.delete"  width="5%"> <img style="cursor:pointer;" border="0" id="delete"/> </a></td>';
                }
                if(in_array("edit",$p_iconos)){
                    $result.= '<td><a href="?id='.$id.'&accion=categoria.formEdit"  width="5%"> <img style="cursor:pointer;" border="0" id="edit"/> </a> </td>';
                }
                #FIN ICONOS DE ACCION
                $result.= '</tr> ';

            }
            $result.= '</table> </div>';
            return $result;
        }
    }
    
    $oCategoria = new Categoria();
?>