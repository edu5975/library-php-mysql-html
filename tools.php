<?php 
    class baseDatos{
        var $cone;
        var $bloque;
        var $numeTuplas;

        function inicializa($serv="g3v9lgqa8h5nq05o.cbetxkdyhwsb.us-east-1.rds.amazonaws.com",$user="btvbl3qetg7cmaxu",$pass="us5wgsva6fyia9rz",$db="z20igopnyit8ea33"){
        //function inicializa($serv="localhost",$user="edu5975",$pass="12345",$db="biblioteca"){
            $this->cone = mysqli_connect($serv,$user,$pass,$db);
            if($this->cone==null)
                exit;
        }

        function consulta($query){
            $this->inicializa();          
            $this->bloque = mysqli_query($this->cone,$query);
            if(mysqli_error($this->cone))
                echo mysqli_error($this->cone);
            if(strpos(strtoupper($query),"SELECT")!==false){                
                $this->numeTuplas = mysqli_num_rows($this->bloque);
            }
            else{
                // INSERT NECESITAMOS EL ID
            }            
            $this->close();
        }

        function saca_tupla($query){
            $this->consulta($query);
            return mysqli_fetch_object($this->bloque);
        }

        function despTabla($query,$agregar = false,$p_iconos=array(), $p_coloRenglon="table-dark"){
            $this->consulta($query);
            $result = '<div class="container"> <table class="table">';
            #CABECERA DE LAS COLUMNAS
            $result.= '<tr class="bg-primary">';
            for ($coluC=0; $coluC < mysqli_num_fields($this->bloque); $coluC++) {   
                $campo = mysqli_fetch_field_direct($this->bloque,$coluC); 
                $result .= '<th class "table-info">'.$campo->name.'</th>';
            }
            $result.='<td colspan = "'.count($p_iconos).'">'.(($agregar)?'<img src = "../iconos/ok.png " height="24"/>':"&nbsp;").'</td>';

            $result.= '</tr>';

            for ($contR=0; $contR < $this->numeTuplas; $contR++) { 
                $result.= '<tr '.(($contR%2)?'class="'.$p_coloRenglon.'"':'').'>';                 
                                
                $tupla = mysqli_fetch_array($this->bloque);
                for ($coluC=0; $coluC < mysqli_num_fields($this->bloque); $coluC++) {    
                    $result.= '<td >'.$tupla[$coluC].' </td>';
                }
                #ICONOS DE ACCION
                if(in_array("ok",$p_iconos)){
                    $result.= '<td> <img src="../iconos/ok.png" height="24"/> </td>';
                }
                if(in_array("delete",$p_iconos)){
                    $result.= '<td> <img src="../iconos/delete.png" height="24"/> </td>';
                }
                if(in_array("edit",$p_iconos)){
                    $result.= '<td> <img src="../iconos/edit.png" height="24"/> </td>';
                }
                #FIN ICONOS DE ACCION
                $result.= '</tr> ';

            }
            $result.= '</table> </div>';
            return $result;
        }

        function close(){
            mysqli_close($this->cone);
        }

        function creaLista($tabla,$id,$campDesp,$campForm,$idSeleccionado=0){    
            $query = 'SELECT '.$id.', '.$campDesp.' FROM '.$tabla;        
            $this->consulta($query);
            $result = '<select class="form-control" name="'.$campForm.'" id="'.$campForm.'" >';   
            
            foreach($this->bloque as $registro)            { 
                $result .= '<option '.(($registro[$id] == $idSeleccionado) ? 'selected' : ' ').' value="'.$registro[$id].'" >'.
                            $registro[$campDesp].'</option>';
            }
            $result .= '</select>';
            return $result;
        }

        //.$this->creaListaMultiple("caracteristica","id","tipo","idCaracteristica",$_SESSION['id'],"idUsuario","tienecaracteristica").
        function creaListaMultiple($tabla,$id,$campDesp,$campForm,$condicion=null,$campo2=null,$tabla2=null){    
            $query = 'SELECT '.$id.', '.$campDesp.' FROM '.$tabla;        
            $this->consulta($query);
            $result = '<select title="Ingresa lo deseado" class="js-example-basic-multiple" name="'.$campForm.'[]" id="'.$campForm.'" multiple="multiple" style="width:100%">';   
            $bloque1 = $this->bloque;

            $arrayS = [];
            if ($condicion!=null) {
                $query = 'SELECT '.$campForm.' FROM '.$tabla2.' WHERE '.$campo2.' = '.$condicion;
                $this->consulta($query);
                foreach($this->bloque as $registro){ 
                    $arrayS[] = $registro[$campForm];
                }
            }

            foreach($bloque1 as $registro){ 
                $result .= '<option value="'.$registro[$id].'"'.(in_array($registro[$id],$arrayS)?'selected':'').'>'.
                            $registro[$campDesp].'</option>';
            }
            $result .= '</select>';
            return $result;
        }

    }
    $BD = new baseDatos();

    
?>