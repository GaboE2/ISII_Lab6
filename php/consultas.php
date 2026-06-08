<?php

    include 'conexion_bd.php';


   /*  var_dump($_POST); // Linea para verificar a donde va cada dato  */

    $codigo = $_POST['codigo'];
    $fecha = $_POST['fecha'];
    $inicio = $_POST['inicio'];
    $motivo = $_POST['motivo'];
    $id_paciente = $_POST['id_paciente'];
    $nombre_completo = $_POST['nombre_completo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo = $_POST['sexo'];
    $telefono = $_POST['telefono'];
    $diagnostico = $_POST['diagnostico'];

// consultas
$query = "INSERT INTO consultas (codigo, fecha, hora, motivo, id_paciente, nombre_completo, fecha_nacimiento, sexo, telefono, diagnostico)
              VALUES ('$codigo', '$fecha', '$inicio', '$motivo', '$id_paciente', '$nombre_completo', '$fecha_nacimiento', '$sexo', '$telefono', '$diagnostico')";
    

    $ejecutar = mysqli_query($conexion, $query);

//Comprobación de registro hecho, en window salta a donde manda luego de ingresarlo en la bd
if ($ejecutar) {
    echo '
        <script>
            alert("Registro Datos Paciente realizado de forma exitosa");
            window.location = "../consultadoctor.html";
    </script>
    ';
}else{
    echo '
    <script>
        alert("Registro NO realizado, inténtelo mas tarde");
        window.location = "../consultadoctor.html";
</script>
';
}

mysqli_close($conexion);

    
 