<?php

    include 'conexion_bd.php';


   /*  var_dump($_POST); // Linea para verificar a donde va cada dato  */

   $fecha_registro = $_POST['fecha_registro'];
   $nombre_paciente = $_POST['nombre_paciente'];
   $id_paciente = $_POST['id_paciente'];
   $enfermedades_cronicas = $_POST['enfermedades_cronicas'];
   $enfermedades_agudas_previas = $_POST['enfermedades_agudas_previas'];
   $cirugias_previas = $_POST['cirugias_previas'];
   $hospitalizaciones_previas = $_POST['hospitalizaciones_previas'];
   $historial_traumas = $_POST['historial_traumas'];
   $alergias_medicamentos = $_POST['alergias_medicamentos'];
   $detalles_reacciones_alergicas = $_POST['detalles_reacciones_alergicas'];
   $enfermedades_hereditarias = $_POST['enfermedades_hereditarias'];
   $historial_enfermedades_graves_familiares = $_POST['historial_enfermedades_graves_familiares'];

     //citapaciente

     $query = "INSERT INTO historialpaciente (fecha_registro, nombre_paciente, id_paciente, enfermedades_cronicas, enfermedades_agudas_previas, cirugias_previas, hospitalizaciones_previas, historial_traumas, alergias_medicamentos, detalles_reacciones_alergicas, enfermedades_hereditarias, historial_enfermedades_graves_familiares)
              VALUES ('$fecha_registro', '$nombre_paciente', '$id_paciente', '$enfermedades_cronicas', '$enfermedades_agudas_previas', '$cirugias_previas', '$hospitalizaciones_previas', '$historial_traumas', '$alergias_medicamentos', '$detalles_reacciones_alergicas', '$enfermedades_hereditarias', '$historial_enfermedades_graves_familiares')";
    

    $ejecutar = mysqli_query($conexion, $query);

//Comprobación de registro hecho, en window salta a donde manda luego de ingresarlo en la bd
if ($ejecutar) {
    echo '
        <script>
            alert("Registro Datos Paciente realizado de forma exitosa");
            window.location = "../historialpaciente.html";
    </script>
    ';
}else{
    echo '
    <script>    
        alert("Registro NO realizado, inténtelo mas tarde");
        window.location = "../historialpaciente.html";
</script>
';
}

mysqli_close($conexion);

    
 