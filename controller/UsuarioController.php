<?php

class UsuarioController{

    private $gestor;

    public function __construct($gestor){
        $this->gestor=$gestor;
    }

    public function registroUsuario(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $email=$_POST['email'];
            $passwordPlana=$_POST['password'];

            //hasheo contraseña
            $passwordHash=password_hash($passwordPlana,PASSWORD_DEFAULT);

            $nuevoUsuario=new Usuario($email,$passwordHash);

            $this->gestor->registroUsuario($nuevoUsuario);

            header('Location: index.php?accion=login');
            exit;
        }
        include 'views/registroUsuario.php';
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $email=$_POST['email'];
            $passwordPlana=$_POST['password'];

            //buscamos el usuario
            $usuario=$this->gestor->buscarUsuarioPorEmail($email);

            //usamos getters del objeto para la validación
            if($usuario && password_verify($passwordPlana,$usuario->getPassword())){

                //login correcto
                $_SESSION['usuario_id']=$usuario->getId();
                $_SESSION['usuario_email']=$usuario->getEmail();

                header('Location: index.php');
                exit;
            }else{
                $error="Credenciales incorrectas.";
            }
        }


        include 'views/login.php';
    }

    public function logout(){
        //vaciamos variables de sesión
        $_SESSION=[];

        //destruimos sesión por completo
        session_destroy();

        //redirigimos al inicio
        header('Location: index.php?accion=login');
        exit;
    }
}

?>