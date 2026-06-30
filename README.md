<<<<<<< HEAD
# Proyecto a Usar ISII - Lab 6 - 30/04/2026

## Integrantes:

- **Baca Flores Gabriel Alejandro**
- **Sierra Huaracha Rodrigo Adolfo**
- **Perez Flores Alyson Gisely**

## Descripción del Proyecto

### Farmacia del Hospital General de Arequipa

La farmacia del Hospital General se asegura de que cada aspecto de su cita, reserva, receta, etc., esté meticulosamente documentado y organizado. Esta estructuración detallada facilita la gestión eficiente de la farmacia, asegura un servicio de calidad para los pacientes y permite una colaboración fluida entre los diferentes departamentos y personal médico.

## Levantamiento y Análisis de Requisitos

### Departamentos
- Cada farmacia está dividida en departamentos.
- Para cada departamento, se desea guardar su identificador, nombre, edificio y presupuesto.

### Doctores
- Cada doctor está asignado a un departamento.
- Para cada doctor, se almacena su identificador, nombre completo (nombres, primer apellido y segundo apellido), especialidad, edad y fecha de nacimiento.

### Pacientes
- Cada paciente está asignado a un departamento.
- Para cada paciente, se almacena su identificador, nombre completo (nombres, primer apellido y segundo apellido), edad, fecha de nacimiento, teléfonos de contacto, dirección e historial médico.

### Medicamentos
- Cada medicamento está asignado a una clase de medicamentos.
- Para cada medicamento, se almacena su identificador, nombre del medicamento, clase de medicamento (antiinflamatorio, antibiótico, etc.), fecha de vencimiento, stock actual y precio.

### Clases de Medicamentos
- Cada clase de medicamentos tiene varios medicamentos asociados.
- Para cada clase de medicamentos, se almacena su identificador y nombre de la clase (antiinflamatorio, antibiótico, etc.).

### Suplementos
- Cada suplemento está asignado a un departamento.
- Para cada suplemento, se almacena su identificador, nombre, stock actual y precio.

### Prescripciones
- Cada prescripción está asignada a un paciente y un doctor.
- Para cada prescripción, se almacena su identificador, fecha de emisión, identificador del paciente, identificador del doctor, identificador del medicamento, dosis e instrucciones.

### Consultas
- Cada consulta está asignada a un paciente y un doctor.
- Para cada consulta, se almacena su identificador, fecha de la consulta, identificador del paciente, identificador del doctor, motivo de la consulta y diagnóstico.

### Historiales Médicos
- Cada historial médico está asignado a un paciente.
- Para cada historial médico, se almacena su identificador, identificador del paciente, detalles del historial y fecha del registro.

### Recetas
- Cada receta está asignada a una consulta y un medicamento.
- Para cada receta, se almacena su identificador, identificador de la consulta, identificador del medicamento, cantidad prescrita y fecha de la receta.

### Citas
- Cada cita está asignada a un paciente y un doctor.
- Para cada cita, se almacena su identificador, fecha de la cita, hora de inicio, hora de fin, identificador del paciente e identificador del doctor.

### Proveedores
- Cada proveedor suministra medicamentos a la farmacia.
- Para cada proveedor, se almacena su identificador, nombre del proveedor, contacto y dirección.

### Pedidos
- Cada pedido está asignado a un proveedor y un medicamento.
- Para cada pedido, se almacena su identificador, identificador del proveedor, fecha del pedido, identificador del medicamento, cantidad y estado del pedido.

### Horarios
- Cada farmacia tiene uno o varios horarios.
- Para cada horario, se almacena su identificador, día, hora de inicio y hora de fin.

### Horarios Asignados
- Cada horario está asignado a un doctor y una farmacia.
- Para cada horario asignado, se almacena su identificador, día, hora de inicio, hora de fin, identificador del doctor e identificador de la farmacia.

## Estructura del Proyecto


## Adaptación Lab 06 (xUnit + Mocking)

Se agregó una capa adaptadora mínima para pruebas:
- `src/Domain`: entidades e interfaces de repositorio.
- `src/Application`: servicios de aplicación.
- `src/Infrastructure/Persistence`: repositorios MySQLi.
- `tests/Unit` y `tests/Integration`: pruebas con PHPUnit y dobles.

Scripts PHP actuales (`php/consultas.php`, `php/consultapaciente.php`) se mantienen como controllers delgados.

## Pipeline CI/CD

Este proyecto implementa un pipeline CI/CD con GitHub Actions que se ejecuta automáticamente en las ramas `main`, `develop` y `desarrollo`.

### Jobs del pipeline:
- **Build and Test**: Instala dependencias, inicializa la BD y ejecuta todas las pruebas con cobertura
- **Code Quality**: Valida el composer.json y audita vulnerabilidades de seguridad
- **Test Summary**: Genera un resumen de la ejecución de pruebas

## Pruebas automatizadas

### Pruebas Unitarias
- `tests/Unit/ConsultaTest.php` — Entidad Consulta (DDD)
- `tests/Unit/PacienteTest.php` — Servicio de pacientes
- `tests/Unit/MedicoTest.php` — Servicio de médicos
- `tests/Unit/LoginServiceTest.php` — Servicio de autenticación

### Pruebas Funcionales
- `tests/Functional/LoginFlowTest.php` — Flujo completo de login
- `tests/Functional/RegistrarPacienteFlowTest.php` — Flujo de registro de paciente

### Pruebas No Funcionales
- `tests/NonFunctional/RegistrarPacientePerformanceTest.php` — Pruebas de rendimiento

### Pruebas de Integración
- `tests/Integration/PacienteRepositoryFakeTest.php` — Repositorio en memoria

## Microservicios

### ms-pacientes
API REST para gestión de pacientes migrada del monolito al bounded context de Pacientes.

### ms-citas
API REST para gestión de citas migrada del monolito al bounded context de Citas.


=======
prueba 
>>>>>>> importar-farmacia
