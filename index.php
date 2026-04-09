<?php
    require_once "autoload.php";
    
    $gestor=new GestorPDO();
    $controller=new Controller($gestor);

    $accion=$_GET['accion'] ?? 'index';

    switch($accion){
        //opciones gestión usuarios
        case 'login':
            $controller->login();
            break;
        case 'registroUsuario':
            $controller->registroUsuario();
            break;
        case 'logout':
            $controller->logout();
        //opciones gestión vehículos
        case 'editar':
            $controller->editar();
            break;
        case 'baja':
            $controller->baja();
            break;
        case 'alta':
            $controller->alta();
            break;
        default:
            $controller->index();
    }
?>