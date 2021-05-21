<?php
    session_start();
    include "head.php";
    include "classPrestamo.php";
    echo $oPrestamo->actuales();
    echo $oPrestamo->historial();

?>