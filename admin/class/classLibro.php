<?php
    if(!class_exists("baseDatos"))
        include "../tools.php";

    class Libro extends baseDatos
    {
        function Libro(){

        }

        function actualizarTablas($tabla,$campo,$idLibro){
            $this->consulta("delete from ".$tabla." WHERE idLibro=".$idLibro);
            $campos = $_POST[$campo];
            if (count($campos)>0) {
                $query = "insert into ".$tabla."(idLibro,".$campo.") values ";
                for ($i=0; $i < count($campos); $i++) {
                    $query.= "(".$idLibro.",".$campos[$i].")";
                    if($i < count($campos)-1)
                        $query.=",";
                }
                $this->consulta($query);
            }
        }

        function accion($cual,$id=-1){
            $result="";
            switch ($cual) {
                case 'delete':
                    $this->consulta("delete from libro where id=".$id);
                    $result=$this->accion("list");
                    break;
                case 'list':
                    $cad="select l.id, l.titulo, concat(a2.nombre,' ',a2.apellidos) as autor, e.nombre as editorial 
                    from libro l 
                    join autores a on l.id = a.idLibro 
                    join autor a2 on a.idAutor = a2.id 
                    join editorial e on l.idEditorial = e.id 
                    group by l.id";
                    $result=$this->showTabla($cad,true,array("edit","delete"),array("10%","30%","30%","10%")); 
                break;
                case 'insert':   
                    $query = "insert into libro set  
                    idioma='".$_POST['idioma']."',
                    titulo='".$_POST['titulo']."',
                    fechaPublicacion='".$_POST['fechapublicacion']."',                    
                    contenido='".$_POST['contenido']."',
                    idEditorial=".$_POST['idEditorial']."";
                    $this->consulta($query);
                    
                    $row=$this->saca_tupla("
                        select id from libro order by id desc limit 1" 
                    ); 
                    
                    $this->actualizarTablas("pertenece","idCategoria",$row->id);
                    $this->actualizarTablas("autores","idAutor",$row->id); 
                                   
                    $photo="";
                    if (isset($_FILES['archFoto']['name'])&& $_FILES['archFoto']['name']>"") {
                        $arreDatos=explode(".",$_FILES['archFoto']['name']); 
                        $photo="pic".$row->id.".".$arreDatos[count($arreDatos)-1]; 
                        move_uploaded_file($_FILES['archFoto']['tmp_name'],"../src/portadas/".$photo);
                        $this->consulta("update libro set imagen = '".$photo."' where id = ".$row->id);
                    }
                    $pdf="";
                    if (isset($_FILES['archPDF']['name'])&& $_FILES['archPDF']['name']>"") {
                        $arreDatos=explode(".",$_FILES['archPDF']['name']); 
                        $pdf="pdf".$row->id.".".$arreDatos[count($arreDatos)-1]; 
                        move_uploaded_file($_FILES['archPDF']['tmp_name'],"../src/archivos/".$pdf);
                        $this->consulta("update libro set imagem = '".$pdf."' where id = ".$row->id);
                    }    
                    $result=$this->accion("list");
                break;
                case 'update':
                    $photo="";
                    if (isset($_FILES['archFoto']['name'])&& $_FILES['archFoto']['name']>"") {
                        $arreDatos=explode(".",$_FILES['archFoto']['name']); 
                        $photo="pic".$_POST['id'].".".$arreDatos[count($arreDatos)-1]; 
                        move_uploaded_file($_FILES['archFoto']['tmp_name'],"../src/portadas/".$photo);
                    }
                    $pdf="";
                    if (isset($_FILES['archPDF']['name'])&& $_FILES['archPDF']['name']>"") {
                        $arreDatos=explode(".",$_FILES['archPDF']['name']); 
                        $pdf="pdf".$_POST['id'].".".$arreDatos[count($arreDatos)-1]; 
                        move_uploaded_file($_FILES['archPDF']['tmp_name'],"../src/archivos/".$pdf);
                    }

                    $query = "update libro set  
                    ".($photo!=""?"imagen = '".$photo."',":"")."
                    ".($pdf!=""?"archivo = '".$pdf."',":"")."
                    idioma='".$_POST['idioma']."',
                    titulo='".$_POST['titulo']."',
                    fechaPublicacion='".$_POST['fechapublicacion']."',                    
                    contenido='".$_POST['contenido']."',
                    idEditorial=".$_POST['idEditorial']." 
                    where id =  ".$_POST['id'];
                    $this->consulta($query);
                    
                    $this->actualizarTablas("pertenece","idCategoria",$_POST['id']);
                    $this->actualizarTablas("autores","idAutor",$_POST['id']); 
                    $result=$this->accion("list");
                break;
    
                case 'formEdit':
                    $row=$this->saca_tupla("
                        select l.id, l.titulo, a.idAutor, l.fechaPublicacion, l.idEditorial, l.contenido, l.idioma, l.archivo, l.imagen 
                        from libro l 
                        join autores a on l.id = a.idLibro 
                        where l.id=".$_REQUEST['id']."  
                        group by l.id" 
                    ); 
    
                case 'formNew':
                    $result.='<div class="container-fluid">
                    <form method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Titulo</label>
                                    <input value= "'.((isset($row->titulo))?$row->titulo:'').'" type="text" class="form-control" name="titulo" placeholder="Nombre del libro" id="inputDefault">
                                </div>
                                <div class="form-group">                                
                                    <label class="col-form-label" for="inputDefault" >Autor</label>'
                                    .$this->creaListaMultiple("autor","id","concat(nombre,' ',apellidos)","idAutor",((isset($row->id)?$row->id:0)),'idLibro','autores').
                                    '
                                </div>  
                                <div class="form-group">                                
                                    <label class="col-form-label" for="inputDefault" >Editorial</label>
                                    '.$this->creaLista("editorial","id","nombre","idEditorial",(((isset($row->idEditorial))?$row->idEditorial:0))).'
                                </div>                                
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Fecha publicación</label>
                                    <input value= "'.((isset($row->fechaPublicacion))?$row->fechaPublicacion:'').'" type="date" class="form-control" name="fechapublicacion" placeholder="fechapublicacion" id="inputDefault">
                                </div>
                                <label class="col-form-label" for="inputDefault" >Idioma</label>
                                    <select class="form-control" name="idioma" id="idioma" >
                                        <option '.(isset($row->idioma)?($row->idioma=="ES"?'selected':''):'').' value="ES" >Español</option>
                                        <option '.(isset($row->idioma)?($row->idioma=="EN"?'selected':''):'').' value="EN" >Ingles</option>
                                    </select>
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Reseña</label>
                                    <textarea class="form-control" id="contenido" rows="3" name="contenido">'.((isset($row->contenido))?$row->contenido:'').'</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">                                
                                    <label class="col-form-label" for="inputDefault" >Autor</label>'
                                    .$this->creaListaMultiple("categoria","id","nombre","idCategoria",((isset($row->id)?$row->id:0)),'idLibro','pertenece').
                                    '
                                </div>   
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Archivo</label>
                                    <input  type="file" accept="application/pdf" class="form-control" name="archPDF" placeholder="" id="inputDefault"/>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="inputDefault" >Foto</label>
                                    <input  type="file" accept="image/*" class="form-control" name="archFoto" placeholder="" id="inputDefault"/>
                                </div>
                                <div class="form-group">
                                    '.((isset($row->id))?'<img src = "../src/portadas/'.$row->imagen.'" height="300" />':'').'                                    
                                </div>
                            </div>
                        </div>                  
                        
                        <input type="hidden" name="accion" value="perfil.update" />        
                        '.(isset($row->id)?'<button class="btn btn-sm- btn-success">Actualizar</button><input type="hidden" name="id" value="'.$row->id.'"/><input type="hidden" name="accion" value="libro.update"     />':'<button class="btn btn-sm- btn-success">Registrar</button><input type="hidden" name="accion" value="libro.insert"     />').'
                    </form>
                </div>';
                
                default:
                    # code...
                    break;
    
            }
            return $result;
        }

        function showTabla($query,$agregar = false,$p_iconos=array(),$p_columna=array(), $p_coloRenglon="table-dark"){
            $this->consulta($query);
            $result = '<div class="container"><span class="badge badge-primary">Libro</span><table class="table" border = "0">';
            #CABECERA DE LAS COLUMNAS
            $result.= '<tr class="bg-primary">';
            for ($coluC=0; $coluC < mysqli_num_fields($this->bloque); $coluC++) {   
                $campo = mysqli_fetch_field_direct($this->bloque,$coluC); 
                $result .= '<th class "table-info" '.((count($p_columna)>0)?' width='.$p_columna[$coluC]:' ').'>'.$campo->name.'</th>';
            }
            $result.='<td colspan = "'.count($p_iconos).'">'.(($agregar)?'<a href="?accion=libro.new"> 
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
                    $result.= '<td><a href="?id='.$id.'&accion=libro.delete"  width="5%"> <img style="cursor:pointer;" border="0" id="delete"/> </a></td>';
                }
                if(in_array("edit",$p_iconos)){
                    $result.= '<td><a href="?id='.$id.'&accion=libro.formEdit"  width="5%"> <img style="cursor:pointer;" border="0" id="edit"/> </a> </td>';
                }
                #FIN ICONOS DE ACCION
                $result.= '</tr> ';

            }
            $result.= '</table> </div>';
            return $result;
        }
    }
    
    $oLibro = new Libro();
?>