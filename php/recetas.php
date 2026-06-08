<?php

    include 'conexion_bd.php';


   /*  var_dump($_POST); // Linea para verificar a donde va cada dato  */


    $fecha_receta = $_POST['fecha_receta'];
    $idr = $_POST['idr'];
    $fecha_emision = $_POST['fecha_emision'];
    $idconsulta = $_POST['idconsulta'];
    $fecha_consulta = $_POST['fecha_consulta'];
    $nombre_paciente = $_POST['nombre_paciente'];
    $fecha_nacimiento_paciente = $_POST['fecha_nacimiento_paciente'];
    $idp = $_POST['idp'];
    $telefono_paciente = $_POST['telefono_paciente'];
    $correo_paciente = $_POST['correo_paciente'];
    $nombre_medico = $_POST['nombre_medico'];
    $idm = $_POST['idm'];
    $especialidad_medico = $_POST['especialidad_medico'];
    $telefono_medico = $_POST['telefono_medico'];
    $correo_medico = $_POST['correo_medico'];
    $idme = $_POST['idme'];
    $nombremed = $_POST['nombremed'];
    $dosis = $_POST['dosis'];
    $admime = $_POST['admime'];
    $frecuencia = $_POST['frecuencia'];
    $duracion = $_POST['duracion'];
    $adicionales = $_POST['adicionales'];


     
    $query = "INSERT INTO recetas (fecha_receta, id_receta, fecha_emision, id_consulta, fecha_consulta, nombre_paciente, fecha_nacimiento_paciente, id_paciente, telefono_paciente, correo_paciente, nombre_medico, id_medico, especialidad_medico, telefono_medico, correo_medico, id_medicamento, nombre_medicamento, dosis_medicamento, forma_administracion, frecuencia_administracion, duracion_tratamiento, informacion_adicional)
    VALUES ('$fecha_receta', '$idr', '$fecha_emision', '$idconsulta', '$fecha_consulta', '$nombre_paciente', '$fecha_nacimiento_paciente', '$idp', '$telefono_paciente', '$correo_paciente', '$nombre_medico', '$idm', '$especialidad_medico', '$telefono_medico', '$correo_medico', '$idme', '$nombremed', '$dosis', '$admime', '$frecuencia', '$duracion', '$adicionales')";
    

    $ejecutar = mysqli_query($conexion, $query);

//Comprobación de registro hecho, en window salta a donde manda luego de ingresarlo en la bd
if ($ejecutar) {
    echo '
        <script>
            alert("Registro Datos Paciente realizado de forma exitosa");
            window.location = "../recetapaciente.html";
    </script>
    ';
}else{
    echo '
    <script>
        alert("Registro NO realizado, inténtelo mas tarde");
        window.location = "../recetapaciente";
</script>
';
}

mysqli_close($conexion);

    
 