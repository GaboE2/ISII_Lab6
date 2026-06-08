<?php

$conexion = mysqli_connect("localhost", "root" , "", "login_db", 3310); // ESTOY DECLArando del xamp del user sin password: root@localhost


// El puerto que añadi en el 3310 es porque no se puede ejecutar bien el xamp en algunas pc, si en tu computadora en el XAMP , en el apartado de mysql 
//tienes otro puerto, indicalo en el espacio de 3310, en mi caso es asi xq lo modifique, SI NO CAMBIAS ESTE PARAMETRO
// RECIBIRAS UN "Access denied for user 'root'@'localhost' ",      

// Si vas a hacer pruebas, descomenta al inicio esto para corroborar la conexión, luego lo comentas si lo vas a subir :)



/*     if($conexion){
        echo "conexión exitosa a la login_db";
    }else{
        echo "no se pudo conectar a login_db";

    }
     */




?>