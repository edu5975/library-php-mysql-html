<?php
    if(!class_exists("baseDatos"))
        include "../tools.php";

    class Prestamo extends baseDatos
    {
        public function Prestamo()
        {
        }

        public function actuales()
        {
            $query = "select l.titulo, concat(a2.nombre,' ',a2.apellidos) as autor, l.imagen, l.id
            from libro l
            join autores a on l.id = a.idLibro
            join autor a2 on a.idAutor = a2.id
            join prestamo p on a.idLibro = p.idLibro
            where '".date("Y-m-d")."' between p.fechaPrestamo and p.fechaEntrega
            and p.idUsuario = ".$_SESSION['id']." 
            group by l.titulo  
            order by  p.fechaPrestamo desc";
            $this->consulta($query);

            $result= '</br> 
            <h5>Actualmente cuentas con los siguientes libros</h5>
            <div id = "actuales" class="container-fluid" >';
            if($this->numeTuplas==0){
                $result.= 'No se encuentra ningún registro actualmente';
            } 
            $col = 0; 
            for ($conR = 0; $conR < $this->numeTuplas;$conR++) {
                $tupla = mysqli_fetch_array($this->bloque);
                if ($conR%6==0) {
                    $result.= '<div class="row">';
                }         
                
                $result.= '<div class="col-md-2" onClick = "libro('.$tupla[3].');" style="text-align: center;">';
                $result.= '<div class="alert alert-dismissible alert-info" style="height:100%; width:100%">';
                $result.= '<img class="portada" alt="'.$tupla[0].'" src="../src/portadas/'.($tupla[2]!=null&&$tupla[2]!=""&&file_exists("../src/portadas/".$tupla[2])?$tupla[2]:'null.png').'" />';
                $result.= '</br>'.$tupla[0];
                $result.= '</br>'.$tupla[1];
                $result.= '</div>';
                $result.= '</div>';
                
                $col++;
                if ($col==6) {
                    $col = 0;
                    $result.= '</div></br>';
                }
            }        
            if($col!=0)   
                $result.= '</div>';
            $result.= '</div>';
            return $result;
        }

        public function historial()
        {
            $query = "select l.titulo, concat(a2.nombre,' ',a2.apellidos) as autor, l.imagen, l.id
            from libro l
            join autores a on l.id = a.idLibro
            join autor a2 on a.idAutor = a2.id
            join prestamo p on a.idLibro = p.idLibro
            where p.idUsuario = ".$_SESSION['id']." 
            order by  p.fechaPrestamo desc";
            $this->consulta($query);

            $result= '
            <h5>Historial de libros</h5>
            <div id = "actuales" class="container-fluid" >'; 
            $col = 0; 
            if($this->numeTuplas==0){
                $result.= 'No cuentas con un historial';
            } 
            for ($conR = 0; $conR < $this->numeTuplas;$conR++) {
                $tupla = mysqli_fetch_array($this->bloque);
                if ($conR%6==0) {
                    $result.= '<div class="row" style="text-align: center;">';
                }                
               
                $result.= '<div class="col-md-2" onClick = "libro('.$tupla[3].');">';
                $result.= '<div class="alert alert-dismissible alert-info" style="height:100%; width:100%">';
                $result.= '<img class="portada" alt="'.$tupla[0].'" src="../src/portadas/'.($tupla[2]!=null&&$tupla[2]!=""&&file_exists("../src/portadas/".$tupla[2])?$tupla[2]:'null.png').'" />';
                $result.= '</br>'.$tupla[0];
                $result.= '</br>'.$tupla[1];
                $result.= '</div>';
                $result.= '</div>';
                
                $col++;
                if ($col==6) {
                    $col = 0;
                    $result.= '</div></br>';
                }
            }        
            if($col!=0)   
                $result.= '</div>';
            $result.= '</div></br></br></br>';
            return $result;
        }
    }
    
    $oPrestamo = new Prestamo();
?>

