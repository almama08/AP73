<?php
    require_once "autoload.php";
    
    $gestor=new GestorPDO();
    $controller=new Controller($gestor);
    $usuarioController=new UsuarioController($gestor);

    $accion=$_GET['accion'] ?? 'index';

    switch($accion){
        //opciones gestión usuarios
        case 'login':
            $usuarioController->login();
            break;
        case 'registroUsuario':
            $usuarioController->registroUsuario();
            break;
        case 'logout':
            $usuarioController->logout();
        //opciones gestión vehículos. Técnica fall-throught
        case 'editar':
            
        case 'baja':
            
        case 'alta':
            if(!isset($_SESSION['usuario_id'])){
                header('Location: index.php?accion=login');
                exit;
            }
            if($accion=='alta')$controller->alta();
            if($accion=='baja')$controller->baja();
            if($accion=='editar')$controller->editar();
        default:
            $controller->index();
    }
?>