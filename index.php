    <?php
        session_start();
        session_destroy();

        include "head.php";
        if (isset($_GET['E'])) {
            switch ($_GET['E']) {
                case 1:
                    echo "<h3>Usuario o contraseña erroneo</h3>";
                    break;
                case 7:
                    echo "<h3>Se ha enviado la contraseña a su correo </h3>";
                    break;
                case 10:
                    echo "<h3>Ya esta registrado el correo, intente con otro o recupere la contraseña</h3>";
                    break;
                case 15:
                    echo "<h3>Contraseña enviada, revisa tu correo</h3>";
                    break;
                case 25:
                    echo "<h3>Correo no existente</h3>";
                    break;
                case 35:
                    echo "<h3>Advertencia</h3>";
                    break;
                case 45:
                    echo "<h3>No tienes derecho de estar aquí</h3>";
                    break;                    
                case 55:
                    echo "<h3>La cuenta se encuentra bloqueada por inactividad, contacte al administrador via correo: 17030434@itcelaya.edu.mx</h3>";
                    break;
            }
        }
        include "classInvitado.php";
        echo $oInvitado->vistaLibros();
          
    ?>
</body>

</html>