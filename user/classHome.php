<?php
    if(!class_exists("baseDatos"))
        include "../tools.php";

    class Home extends baseDatos
    {
        public function Home()
        {
        }

        public function vistaLibros($actual = 0,$parece = "", $categoria = 0)
        {
            $query = "select l.titulo, concat(a2.nombre,' ',a2.apellidos) as autor, l.imagen, l.id
            from libro l 
            join autores a on l.id = a.idLibro 
            join autor a2 on a.idAutor = a2.id 
            join pertenece p on l.id = p.idLibro  
            where (l.titulo like '%".$parece."%' or concat(a2.nombre,' ',a2.apellidos) like '%".$parece."%' )
            ".($categoria!=0?" and p.idCategoria = ".$categoria:"")."
            group by l.titulo ";
            $this->consulta($query);

            $result= '';
            $col = 0; 
            for ($conR = 0; $conR < $this->numeTuplas;$conR++) {
                $tupla = mysqli_fetch_array($this->bloque);
                if($actual*12 <= $conR && $conR < ($actual+1)*12){
                    if ($conR%4==0) {
                        $result.= '<div class="row">';
                    }                
                    $result.= '<div class="col-md-3" onClick = "libro('.$tupla[3].');">';
                    $result.= '<div class="alert alert-dismissible alert-info" style="height:100%; width:100%; ">';
                    $result.= '<img class="portada" alt="'.$tupla[0].'" src="../src/portadas/'.($tupla[2]!=null&&$tupla[2]!=""&&file_exists("../src/portadas/".$tupla[2])?$tupla[2]:'null.png').'" />';
                    $result.= '</br>'.$tupla[0];
                    $result.= '</br>'.$tupla[1];
                    $result.= '</div>';
                    $result.= '</div>';
                    
                    $col++;
                    if ($col==4) {
                        $col = 0;
                        $result.= '</div></br>';
                    }
                }
            }        
            if($col!=0)   
                $result.= '</div>';
            $result.=   '<div id="paginas">'.
                            $this->numeRegistros($actual,$parece,$categoria).
                        '</div>';
            if($this->numeTuplas==0)
                $result = '<h4>No se encuentro ningún registro</h4><img src="../iconos/nada.png"/>';
            return $result;
        }

        function librosAutocompletar(){
            $query = "select l.id, l.titulo, concat(a2.nombre,' ',a2.apellidos) as autor, l.imagen
            from libro l
            join autores a on l.id = a.idLibro
            join autor a2 on a.idAutor = a2.id 
            group by l.titulo";
            $this->consulta($query);
            $result = '';              
            foreach($this->bloque as $registro){ 
                $result .= $registro['id'].'|'.$registro['titulo'].'|'.$registro['autor'].'|'.$registro['imagen'].'|';
            }
            return $result;
        }

        function numeRegistros($actual = 0,$parece = "",$categoria=0){
            $total = $this->numeTuplas;
            $result =   '<div>
                            <ul class="pagination pagination-lg">';

            for ($i=0; $i < $total/12; $i++) { 
                $result .= '<li class="page-item '.($i==$actual?'active':'').'">
                                <a class="page-link " onClick="cambiaPagina('.$i.',\''.$parece.'\','.$categoria.')">'.($i+1).'</a>
                            </li>';
            }
            $result.=       '</ul>
                        </div>';
            return $result;
        }

        function buscador(){
            $result = '</br><div class="container-fluid">
            <div class="row">
            <div class="col-md-2" >
                <label aria-describedby="Buscador" placeholder="Buscador"></label>
            </div>
            <div class="col-md-9" >
                <input id="txtbuscador" name="buscador" class="form-control" aria-describedby="Buscador" placeholder="Buscador">
            </div>
            <div class="col-md-1" >
                <button id = "btnbuscador" type="button" onclick="buscadorLiBo();" class="btn btn-primary">Buscar</button>
            </div>
            </div>
            </div>';

            return $result;
        }

        function categorias(){
            $query = 'SELECT nombre, id FROM categoria';        
            $this->consulta($query);            

            $result = '<ul id="menu">
                            <li class="ui-widget-header"><div>Categorias</div></li>   ';  
            foreach($this->bloque as $registro){ 
                $result .= '<li class="list-group-item active" onClick="cambiaPagina(0,\'\','.$registro['id'].')" ><div>'.$registro['nombre'].'</div></li>';
            }                    
            $result.= '</ul>';
            return $result;
        }
    }
    
    $oHome = new Home();

    if(isset($_GET['OPT'])){
        switch ($_GET['OPT']) {
            case 1:          
                echo $oHome->librosAutocompletar();
                break;  
            case 2:
                echo $oHome->vistaLibros($_POST['numero'],$_POST['parece'],isset($_POST['categoria'])?$_POST['categoria']:0);
                break;
        }
    }
?>

