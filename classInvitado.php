<?php
    if(!class_exists("baseDatos"))
        include "tools.php";

    class Invitado extends baseDatos
    {
        public function Invitado()
        {
        }

        public function vistaLibros()
        {
            $query = "select l.titulo, concat(a2.nombre,' ',a2.apellidos) as autor, l.imagen 
            from libro l 
            join autores a on l.id = a.idLibro 
            join autor a2 on a.idAutor = a2.id 
            group by l.titulo";
            $this->consulta($query);

            $result= '</br> <div id = "vistaLibros" class="container-fluid" style="text-align: center;" title="Para poder ver el libro inicia sesión">'; 
            $result.= '<div class="alert alert-dismissible alert-info" style="height:100%; width:100%">';
            $result.= '<h5>Para poder acceder al siguiente contenido y más debes ser un usuario registrado</h5>';
            $col = 0; 
            for ($conR = 0; $conR < $this->numeTuplas;$conR++) {
                $tupla = mysqli_fetch_array($this->bloque);
                if ($conR%12==0) {
                    $result.= '<div class="row">';
                }         
                if (file_exists("src/portadas/".$tupla[2])) {
                    $result.= '<div class="col-md-1" >';
                    $result.= '<img class="portada" alt="'.$tupla[0].'" src="src/portadas/'.($tupla[2]!=null&&$tupla[2]!=""?$tupla[2]:'null.png').'" />';
                    $result.= '</div>';                
                    $col++;
                }
                if ($col==12) {
                    $col = 0;
                    $result.= '</div></br>';
                }
            }        
            if($col!=0)   
                $result.= '</div>';
            $result.= '</div></div>';
            return $result;
        }

        
    }
    
    $oInvitado = new Invitado();

    
?>


