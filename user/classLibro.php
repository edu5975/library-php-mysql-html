<?php
    if(!class_exists("baseDatos"))
        include "../tools.php";

    class Libro extends baseDatos
    {
        function Libro(){

        }

        function info($idLibro,$tabla,$tablaRelacion,$info,$campoRelacion){    
            $query = 'select '.$info.' 
            from '.$tabla.' a 
            join '.$tablaRelacion.' b on a.id = b.'.$campoRelacion.' 
            where idLibro = '.$idLibro;   

            $this->consulta($query);
            $result = "";            
            foreach($this->bloque as $registro)            { 
                $result .= ' '.$registro[$info].'</br>';
            }
            return $result;
        }

        function mostrar($id){
            $libro = $this->saca_tupla("select l.titulo, l.contenido, e.nombre as editorial, l.archivo, l.imagen, l.idioma, l.fechaPublicacion
            from libro l 
            join editorial e on l.idEditorial = e.id
            where l.id =".$id);
            $result = '</br>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="alert alert-dismissible alert-primary">
                                    <h2>'.$libro->titulo.'</h2>
                                    <img src="../src/portadas/'.($libro->imagen!=null&&$libro->imagen!=""&&file_exists("../src/portadas/".$libro->imagen)?$libro->imagen:'null.png').'" style = "width:80%"/>
                                    <p>Editorial: '.$libro->editorial.'</p>
                                    <p>Publicación: '.$libro->fechaPublicacion.'</p>
                                </div>
                            </div>
                            <div class="col-md-8">   
                                    <div class="card border-primary mb-3" >
                                            <div class="card-header">Contenido</div>
                                            <div class="card-body">
                                                <p>'.$libro->contenido.'</p>
                                            </div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card border-primary mb-3" >
                                            <div class="card-header">Autores</div>
                                            <div class="card-body">
                                                '.$this->info($id,'autor','autores',"concat(nombre,' ',apellidos)",'idAutor').'
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-primary mb-3"   >
                                            <div class="card-header">Categorias</div>
                                            <div class="card-body">
                                                '.$this->info($id,'categoria','pertenece','nombre','idCategoria').'
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div id = "botonesLibro">
                                    '.$this->verifica($id).'
                                </div>
                            </div>
                        </div>
                    </div>';
            echo $result;
        }
        
        function verifica($id, $idUsuario = 0){
            $tupla = $this->saca_tupla("select p.id, p.fechaEntrega - p.fechaPrestamo as dias, l.archivo
            from prestamo p 
            join libro l on p.idLibro = l.id  
            where '".date("Y-m-d")."' between p.fechaPrestamo and p.fechaEntrega 
            and p.idUsuario = ".($idUsuario==0?$_SESSION['id']:$idUsuario).
            " and p.idLibro = ".$id." 
            order by p.id desc");
            if ($this->numeTuplas) {
                $result = '<button type="button" class="btn btn-primary" title="Si desea regresar el libro de clic" onClick="desactivar('.$tupla->id.','.$id.','.($idUsuario==0?$_SESSION['id']:$idUsuario).');">Desactivar</button>';
                if($tupla->archivo!=null && $tupla->archivo!="" && file_exists("../src/archivos/".$tupla->archivo))
                    $result .= '<a href="../src/archivos/'.$tupla->archivo.'" target="_BLANK">
                                <button type="button" class="btn btn-primary" title="Si desea abrir el libro de clic" >
                                    Abrir libro
                                </button>  
                             </a>';
                else
                    $result .= '<button disabled="disabled" type="button" class="btn btn-primary" title="Recurso no encontrado" >
                                    Abrir libro
                                </button>  ';
                $result.= '<button type="button" class="btn btn-primary"  title="Si desea extender el tiempo del libro de clic"  onClick="extender('.$tupla->id.','.$id.','.($idUsuario==0?$_SESSION['id']:$idUsuario).');">Extender</button>';
                $result.= '</br>Días restantes del libro: '.$tupla->dias.', para extender otros 7 días a partir de hoy de clic en extender.';
            }
            else
                $result = '<button type="button" class="btn btn-primary" onClick="activar('.$id.','.($idUsuario==0?$_SESSION['id']:$idUsuario).');">Activar</button>';
            return $result;
        }

        function activar($idLibro,$idUsuario){
            $this->consulta("
                insert into prestamo(idLibro, idUsuario, fechaPrestamo, fechaEntrega) 
                values 
                (".$idLibro.",".$idUsuario.",'".date("Y-m-d")."','".date("Y-m-d",strtotime(date("Y-m-d")."+ 7 days"))."');"
            );
        }

        function desactivar($id){
            $this->consulta("
                update prestamo set fechaEntrega = '".date("Y-m-d",strtotime(date("Y-m-d")."- 1 days"))."' where id = ".$id
            );
        }

        function extender($id){
            $this->consulta("
                update prestamo set fechaEntrega = '".date("Y-m-d",strtotime(date("Y-m-d")."+ 7 days"))."' where id = ".$id
            );
        }
    }    
    $oLibro = new Libro();

    if (isset($_GET['OPT'])){
        switch ($_GET['OPT']) {
            case '1':
                //echo $_POST['idLibro'].$_POST['idUsuario'];
                $oLibro->activar( $_POST['idLibro'],$_POST['idUsuario']);
                echo $oLibro->verifica($_POST['idLibro'],$_POST['idUsuario']);
                break;
            case '2':
                //echo $_POST['idLibro'].$_POST['idUsuario'];
                $oLibro->desactivar( $_POST['id']);
                echo $oLibro->verifica($_POST['idLibro'],$_POST['idUsuario']);
                break;
            case '3':
                //echo $_POST['idLibro'].$_POST['idUsuario'];
                $oLibro->extender( $_POST['id']);
                echo $oLibro->verifica($_POST['idLibro'],$_POST['idUsuario']);
                break;
        }
    }
?>