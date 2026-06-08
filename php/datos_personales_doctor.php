<?php

    include 'conexion_bd.php';


   /*  var_dump($_POST); // Linea para verificar a donde va cada dato  */

   $codigo = $_POST['codigo'];
   $especialidad = $_POST['especialidad'];
   $nombres = $_POST['nombres'];
   $apellido1 = $_POST['apellido1'];
   $apellido2 = $_POST['apellido2'];
   $dni = $_POST['dni'];
   $fecha = $_POST['fecha'];
   $sexo = $_POST['sexo'];
   $contacto = $_POST['contacto'];
   $correo = $_POST['correo'];

   $query = "INSERT INTO registro_doctor_usuario(codigo, especialidad, nombres, apellido1, apellido2, dni, fecha, sexo, contacto, correo)
          VALUES('$codigo', '$especialidad', '$nombres', '$apellido1', '$apellido2', '$dni', '$fecha', '$sexo', '$contacto', '$correo')";


    $ejecutar = mysqli_query($conexion, $query);
    
//Comprobación de registro hecho, en window salta a donde manda luego de ingresarlo en la bd
if ($ejecutar) {
    echo '
        <script>
            alert("Registro Datos Paciente realizado de forma exitosa");
            window.location = "../perfildoctor.html";
    </script>
    ';
}else{
    echo '
    <script>
        alert("Registro NO realizado, inténtelo mas tarde");
        window.location = "../perfildoctor.html";
</script>
';
}

mysqli_close($conexion);

    
 