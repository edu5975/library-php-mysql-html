<?php

    include "head.php";
    session_start();
    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
        #echo "bienvenido administrador".'<a class="btn btn-info btn-sm" href="../index.php" >Cerrar sesión</a>';
    }
    else
        header("location: ../index.php?E=45");

    if(isset($_REQUEST['accion'])){
        if(isset($_POST['accion'])){
            switch ($_POST['accion']) {
                //AUTOR
                case 'autor.insert':
                    include "class/classAutor.php";
                    echo $oAutor->accion("insert");
                    break;
                case 'autor.update':
                    include "class/classAutor.php";
                    echo $oAutor->accion("update");
                break;
                //CATEGORIA
                case 'categoria.insert':
                    include "class/classCategoria.php";
                    echo $oCategoria->accion("insert");
                    break;
                case 'categoria.update':
                    include "class/classCategoria.php";
                    echo $oCategoria->accion("update");
                break;
                //EDITORIAL
                case 'editorial.insert':
                    include "class/classEditorial.php";
                    echo $oEditorial->accion("insert");
                    break;
                case 'editorial.update':
                    include "class/classEditorial.php";
                    echo $oEditorial->accion("update");
                break;
                //USUARIO
                case 'usuario.insert':
                    include "class/classUsuario.php";
                    echo $oUsuario->accion("insert");
                    break;
                case 'usuario.update':
                    include "class/classUsuario.php";
                    echo $oUsuario->accion("update");
                break;
                //LIBRO
                case 'libro.insert':
                    include "class/classLibro.php";
                    echo $oLibro->accion("insert");
                    break;
                case 'libro.update':
                    include "class/classLibro.php";
                    echo $oLibro->accion("update");
                break;
            }
        }
        else{
            switch ($_REQUEST['accion']) {
                //AUTOR
                case 'autor.list':
                    include "class/classAutor.php";
                    echo $oAutor->accion("list");
                    break;
                case 'autor.new':
                    include "class/classAutor.php";
                    echo $oAutor->accion("formNew");
                    break;
                case 'autor.delete':
                    include "class/classAutor.php";
                    echo $oAutor->accion("delete",$_REQUEST['id']);
                    break;
                case 'autor.formEdit':
                    include "class/classAutor.php";
                    echo $oAutor->accion("formEdit");
                break;
                //CATEGORIA
                case 'categoria.list':
                    include "class/classCategoria.php";
                    echo $oCategoria->accion("list");
                    break;
                case 'categoria.new':
                    include "class/classCategoria.php";
                    echo $oCategoria->accion("formNew");
                    break;
                case 'categoria.delete':
                    include "class/classCategoria.php";
                    echo $oCategoria->accion("delete",$_REQUEST['id']);
                    break;
                case 'categoria.formEdit':
                    include "class/classCategoria.php";
                    echo $oCategoria->accion("formEdit");
                break;
                //EDITORIAL
                case 'editorial.list':
                    include "class/classEditorial.php";
                    echo $oEditorial->accion("list");
                    break;
                case 'editorial.new':
                    include "class/classEditorial.php";
                    echo $oEditorial->accion("formNew");
                    break;
                case 'editorial.delete':
                    include "class/classEditorial.php";
                    echo $oEditorial->accion("delete",$_REQUEST['id']);
                    break;
                case 'editorial.formEdit':
                    include "class/classEditorial.php";
                    echo $oEditorial->accion("formEdit");
                break;
                //USUARIO
                case 'usuario.list':
                    include "class/classUsuario.php";
                    echo $oUsuario->accion("list");
                    break;
                case 'usuario.new':
                    include "class/classUsuario.php";
                    echo $oUsuario->accion("formNew");
                    break;
                case 'usuario.delete':
                    include "class/classUsuario.php";
                    echo $oUsuario->accion("delete",$_REQUEST['id']);
                    break;
                case 'usuario.formEdit':
                    include "class/classUsuario.php";
                    echo $oUsuario->accion("formEdit");
                break;
                //LIBRO
                case 'libro.list':
                    include "class/classLibro.php";
                    echo $oLibro->accion("list");
                    break;
                case 'libro.new':
                    include "class/classLibro.php";
                    echo $oLibro->accion("formNew");
                    break;
                case 'libro.delete':
                    include "class/classLibro.php";
                    echo $oLibro->accion("delete",$_REQUEST['id']);
                    break;
                case 'libro.formEdit':
                    include "class/classLibro.php";
                    echo $oLibro->accion("formEdit");
                break;
            }
        }
    }
    else{
        
        include "class/classLibro.php";
        echo $oLibro->accion("list");
    }
?>