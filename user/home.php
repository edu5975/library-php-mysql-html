<?php
    session_start();
    include "head.php";
    include "classHome.php";
    echo $oHome->buscador().'</br>';
    echo '<div class="row">
        <div class="col-md-2">        
            <div id = "categorias" class="container-fluid" style="text-align: center;">'.
                $oHome->categorias().'
            </div>
        </div>
        <div class="col-md-10">
            <div id = "vistaLibros" class="container-fluid" style="text-align: center; ">'.
                $oHome->vistaLibros().
            '</div>
        </div>';

?>