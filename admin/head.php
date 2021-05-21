<!DOCTYPE html>
<html>

<head>
    <title>Biblioteca</title>
    <meta charset="utf-8">
    <link rel='stylesheet' type='text/css' media='screen' href='../CSS/Cerulean.css'>    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />  
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="../tools.js"></script>
    <script>
        $(document).ready(function(){
            $('.js-example-basic-multiple').select2();
            agregarTooltips();
        });
    </script> 

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="?accion=libro.list">Biblioteca</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">    
                <li class="nav-item">
                    <a class="nav-link" href="?accion=libro.list">Libro</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="?accion=usuario.list">Usuario</a>
                </li>             
                <li class="nav-item">
                    <a class="nav-link" href="?accion=autor.list">Autor</a>
                </li>  
                <li class="nav-item">
                    <a class="nav-link" href="?accion=categoria.list">Categoria</a>
                </li>  
                <li class="nav-item">
                    <a class="nav-link" href="?accion=editorial.list">Editorial</a>
                </li>  
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">                    
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php" title="Cerrar sesión"><img id="csesion"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onClick="acercade();"><img id="about"></a>
                    </li>
                </ul>
            </form>
        </div>
    </nav>