<?php

    include 'conexion_bd.php';


   /*  var_dump($_POST); // Linea para verificar a donde va cada dato  */

   $codigo = $_POST['codigo'];
   $fecha_consulta = $_POST['fecha'];
   $hora_consulta = $_POST['hora_consulta'];
   $duracion_consulta = $_POST['duracion_consulta'];
   $motivo_consulta = $_POST['motivo_consulta'];
   $nombre_paciente = $_POST['nombre_paciente'];
   $id_paciente = $_POST['id_paciente'];
   $telefono_paciente = $_POST['telefono_paciente'];
   $correo_paciente = $_POST['correo_paciente'];
   $fecha_nacimiento_paciente = $_POST['fecha_nacimiento_paciente'];
   $sexo_paciente = $_POST['sexo_paciente'];
   $nombre_medico = $_POST['nombre_medico'];
   $id_medico = $_POST['id_medico'];
   $especialidad_medico = $_POST['especialidad_medico'];
   $telefono_medico = $_POST['telefono_medico'];
   $correo_medico = $_POST['correo_medico'];
   $diagnostico = $_POST['diagnostico'];
   $evaluacion = $_POST['evaluacion'];

     //citapaciente

     $query = "INSERT INTO consultapaciente (codigo, fecha_consulta, hora_consulta, duracion_consulta, motivo_consulta, nombre_paciente, id_paciente, telefono_paciente, correo_paciente, fecha_nacimiento_paciente, sexo_paciente, nombre_medico, id_medico, especialidad_medico, telefono_medico, correo_medico, diagnostico, evaluacion)
              VALUES ('$codigo', '$fecha_consulta', '$hora_consulta', '$duracion_consulta', '$motivo_consulta', '$nombre_paciente', '$id_paciente', '$telefono_paciente', '$correo_paciente', '$fecha_nacimiento_paciente', '$sexo_paciente', '$nombre_medico', '$id_medico', '$especialidad_medico', '$telefono_medico', '$correo_medico', '$diagnostico', '$evaluacion')";
    

    $ejecutar = mysqli_query($conexion, $query);

//Comprobación de registro hecho, en window salta a donde manda luego de ingresarlo en la bd
if ($ejecutar) {
    echo '
        <script>
            alert("Registro Datos Paciente realizado de forma exitosa");
            window.location = "../consultapaciente.html";
    </script>
    ';
}else{
    echo '
    <script>
        alert("Registro NO realizado, inténtelo mas tarde");
        window.location = "../consultapaciente.html";
</script>
';
}

mysqli_close($conexion);

    
 