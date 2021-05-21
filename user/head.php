<!DOCTYPE html>
<html>

<head>
    <title>Biblioteca</title>
    
    <link rel='stylesheet' type='text/css' media='screen' href='../CSS/Cerulean.css'>  
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
    <script src="../tools.js"></script>

    <script>
        $(document).ready(function(){
            autocompletarBuscador();
            agregarTooltips();

            $("#txtbuscador").keyup(function(event) {
                if (event.keyCode === 13) {
                    $("#btnbuscador").click();
                    $("#btnbuscador").focus();
                }
            });

            $( "#menu" ).menu({
                items: "> :not(.ui-widget-header)"
            });
        });
    </script>
    <style>
        .ui-menu { width: 200px; }
        .ui-widget-header { padding: 0.2em; }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="home.php" title="Ir a la página principal">Biblioteca</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">                              
                <li class="nav-item">
                    <a class="nav-link" href="home.php" title="Ir a la página principal">Inicio</a>
                </li>               
                <li class="nav-item">
                    <a class="nav-link" href="prestamo.php" title="Historial de prestamos">Prestamos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="perfil.php" title="Editar perfil">Mi perfil</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">    
                    <li class="nav-item">
                        <img src= <?php echo ($_SESSION['foto']!=null&&$_SESSION['foto']!=""?'../src/usuarios/'.$_SESSION['foto']:'../src/usuarios/0.jpg') ?> id = 'perfil'>
                    </li>        
                    <li class="nav-item">
                        <a class="nav-link" href=""> <?php echo $_SESSION['nombre'] ?>  </a>
                    </li>        
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php" title="Cerrar sesión"><img id="csesion"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onClick="acercade();" title="Acerca de"><img id="about"></a>
                    </li>
                </ul>
            </form>
        </div>
    </nav>