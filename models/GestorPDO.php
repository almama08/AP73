<?php

class GestorPDO extends Connection{

public function __construct(){
    parent::__construct();
}

public function listar(){
    $lista=[];
    $consulta='SELECT * FROM flota_vehiculos';
    $rtdo=$this->getConn()->query($consulta);
    while($value=$rtdo->fetch(PDO::FETCH_ASSOC)){
        if($value['tipo_vehiculo']=='Coche'){
            $vehiculo=new Coche(
                $value['marca'],
                $value['modelo'],
                $value['matricula'], 
                $value['precio_dia'], 
                $value['numero_puertas'], 
                $value['tipo_combustible'], 
                $value['id']
            );
        }else{
            $vehiculo=new Motocicleta(
                $value['marca'],
                $value['modelo'],
                $value['matricula'], 
                $value['precio_dia'], 
                $value['cilindrada'], 
                $value['incluye_casco'], 
                $value['id']
            );
        }
        $lista[]=$vehiculo;
    }
    return $lista;
}

public function anyadir($vehiculo){
    $sql='INSERT INTO flota_vehiculos (marca, modelo, matricula, precio_dia, tipo_vehiculo, numero_puertas, tipo_combustible, cilindrada, incluye_casco)
    VALUES (:marca, :modelo, :matricula, :precio, :tipo, :puertas, :motor, :cil, :casco)';
    $stmt=$this->getConn()->prepare($sql);

    $stmt->bindValue(':marca',$vehiculo->getMarca());
    $stmt->bindValue(':modelo',$vehiculo->getModelo());
    $stmt->bindValue(':matricula',$vehiculo->getMatricula());
    $stmt->bindValue(':precio',$vehiculo->getPrecioDia());

    if(get_class($vehiculo)=="Coche"){
        $stmt->bindValue(':tipo','Coche');
        $stmt->bindValue(':puertas',$vehiculo->getNumeroPuertas());
        $stmt->bindValue(':motor',$vehiculo->getTipoCombustible());

        $stmt->bindValue(':cil',null);
        $stmt->bindValue(':casco',null);
    }else{
        $stmt->bindValue(':tipo','Motocicleta');
        $stmt->bindValue(':cil',$vehiculo->getCilindrada());
        $stmt->bindValue(':casco',$vehiculo->getIncluyeCasco(),PDO::PARAM_BOOL);

        $stmt->bindValue(':puertas',null);
        $stmt->bindValue(':motor',null);
    }
    return $stmt->execute();
}

public function eliminar($matricula){
    $sql='DELETE FROM flota_vehiculos WHERE matricula=:mat';
    $stmt=$this->getConn()->prepare($sql);
    $stmt->bindValue(':mat',$matricula);
    return $stmt->execute();
}

public function obtenerVehiculo($matricula){
    $sql='SELECT * FROM flota_vehiculos WHERE matricula=:mat';
    $stmt=$this->getConn()->prepare($sql);
    $stmt->bindValue(':mat',$matricula);
    $stmt->execute();

    $res=$stmt->fetch(PDO::FETCH_ASSOC);

    if($res){
        if($res['tipo_vehiculo']=="Coche"){
            return new Coche($res['marca'], $res['modelo'], $res['matricula'], $res['precio_dia'], $res['numero_puertas'], $res['tipo_combustible']);
        }else{
            return new Motocicleta($res['marca'], $res['modelo'], $res['matricula'], $res['precio_dia'], $res['cilindrada'], $res['incluye_casco']);
        }
    }
    return null;
}

public function modificar($vehiculo){
    $sql="UPDATE flota_vehiculos SET marca = :marca, 
    modelo = :modelo, precio_dia = :precio, 
    numero_puertas = :puertas, tipo_combustible = :motor, 
    cilindrada = :cil, incluye_casco = :casco WHERE matricula = :mat";

    $stmt=$this->getConn()->prepare($sql);

    $stmt->bindValue(':marca', $vehiculo->getMarca());
    $stmt->bindValue(':modelo', $vehiculo->getModelo());
    $stmt->bindValue(':precio', $vehiculo->getPrecioDia());
    $stmt->bindValue(':mat', $vehiculo->getMatricula());

    if(get_class($vehiculo)=="Coche"){
        $stmt->bindValue(':puertas', $vehiculo->getNumeroPuertas());
        $stmt->bindValue(':motor', $vehiculo->getTipoCombustible());
        $stmt->bindValue(':cil', null);
        $stmt->bindValue(':casco', null);
    }else{
        $stmt->bindValue(':cil', $vehiculo->getCilindrada());
        $stmt->bindValue(':casco', $vehiculo->getIncluyeCasco(),PDO::PARAM_BOOL);
        $stmt->bindValue(':puertas', null);
        $stmt->bindValue(':motor', null);
    }
    return $stmt->execute();
}

//operaciones gestión usuarios

public function registroUsuario(Usuario $usuario){
    $sql='INSERT INTO Usuario (email, password) VALUES (:email, :password)';
    $stmt=$this->conn->prepare($sql);

    $stmt->bindValue(':email',$usuario->getEmail());
    $stmt->bindValue(':password',$usuario->getPassword());

    return $stmt->execute();
}

public function buscarUsuarioPorEmail($email){
    $sql='SELECT * FROM Usuario WHERE email= :email LIMIT 1';
    $stmt=$this->conn->prepare($sql);
    $stmt->bindValue(':email',$email);
    $stmt->execute();

    $value=$stmt->fetch(PDO::FETCH_ASSOC);

    //si ha encontrado algo, creamos y devolvemos el objeto usuario
    if($value){
        return new Usuario($value['email'],$value['password'],$value['id']);
    }
    //si no existe, devolvemos false o null
    return false;
}
}
?>