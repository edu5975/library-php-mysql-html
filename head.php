<!DOCTYPE html>
<html>

<head>
    <title>Biblioteca</title>
    <meta charset="utf-8">
    <link rel='stylesheet' type='text/css' media='screen' href='CSS/Cerulean.css'>  
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="tools.js"></script>

    <script>
        $(document).ready(function(){
            agregarTooltips();
        });
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">Biblioteca</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="formAcceso.php">Ingresar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="formRegistro.php">Registro</a>
                </li>
                <li class="nav-item">
                    <a onClick="acercade();" class="nav-link">Acerca</a>
                </li>
            </ul>
        </div>

        
    </nav>
