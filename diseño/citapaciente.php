<?php

    include 'conexion_bd.php';


   /*  var_dump($_POST); // Linea para verificar a donde va cada dato  */

   $idc = $_POST['idc'];
   $fecha_cita = $_POST['fecha_cita'];
   $hora_cita = $_POST['hora_cita'];
   $duracion_cita = $_POST['duracion_cita'];
   $motivo_cita = $_POST['motivo_cita'];
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

     //citapaciente

     $query = "INSERT INTO citapaciente(id_cita, fecha_cita, hora_cita, duracion_cita, motivo_cita, nombre_paciente, id_paciente, telefono_paciente, correo_paciente, fecha_nacimiento_paciente, sexo_paciente, nombre_medico, id_medico, especialidad_medico, telefono_medico, correo_medico)
              VALUES ('$idc', '$fecha_cita', '$hora_cita', '$duracion_cita', '$motivo_cita', '$nombre_paciente', '$id_paciente', '$telefono_paciente', '$correo_paciente', '$fecha_nacimiento_paciente', '$sexo_paciente', '$nombre_medico', '$id_medico', '$especialidad_medico', '$telefono_medico', '$correo_medico')";
    

    $ejecutar = mysqli_query($conexion, $query);

//Comprobación de registro hecho, en window salta a donde manda luego de ingresarlo en la bd
if ($ejecutar) {
    echo '
        <script>
            alert("Registro Datos Paciente realizado de forma exitosa");
            window.location = "../citapaciente.html";
    </script>
    ';
}else{
    echo '
    <script>
        alert("Registro NO realizado, inténtelo mas tarde");
        window.location = "../citapaciente.html";
</script>
';
}

mysqli_close($conexion);

    
 