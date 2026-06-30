
# Proyecto final 

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

## Laboratorio 5: Pruebas Unitarias y Dobles de Prueba
### Archivos creados

| Archivo | Descripción |
|---|---|
| `php/Usuario.php` | Entidad de Dominio con invariantes de negocio |
| `php/IUsuarioRepository.php` | Interfaz del repositorio (permite mockear en tests) |
| `php/UsuarioService.php` | Application Service que orquesta el caso de uso de registro |
| `tests/unit/UsuarioTest.php` | Pruebas unitarias de los invariantes de la Entidad |
| `tests/unit/UsuarioServiceTest.php` | Pruebas del Service usando **Test Doubles (Mocks)** del repositorio |

### Invariantes de Dominio (Entidad Usuario)
Extraídos de la lógica real de `procesar_registro.php`:

1. `rol` debe ser uno de: `paciente`, `doctor`, `administrador`
2. `password` no puede estar vacía
3. Si `rol === 'doctor'`, `especialidad` es obligatoria

### Casos de prueba implementados

**UsuarioTest.php** (invariantes, sin dependencias externas):
- Crea un paciente válido correctamente
- Crea un doctor con especialidad correctamente
- Rol inválido lanza `InvalidArgumentException`
- Password vacía lanza `InvalidArgumentException`
- Doctor sin especialidad lanza `InvalidArgumentException`

**UsuarioServiceTest.php** (mocking del repositorio con `createMock`):
- Registra un usuario nuevo correctamente (mock simula que el documento no existe)
- Lanza excepción si el número de documento ya existe (verifica que `guardar()` nunca se llama)
- No guarda si el rol es inválido (la validación del dominio detiene el flujo antes de tocar el repositorio)

### Resultados de ejecución

```bash
vendor/bin/phpunit
```
**156 tests, 260 assertions — OK**

### Reporte de cobertura de código

Generado en formato HTML con PCOV:

```bash
vendor/bin/phpunit --coverage-html reports/coverage-html
```

Disponible en `reports/coverage-html/index.html`.

### Estrategia de Git (Branching)

Se trabajó en una rama feature aislada, sin modificar ningún archivo existente del sistema (`procesar_registro.php`, `UsuarioRepository.php` permanecen intactos):

- **PR #38**: `feature/lab04-dominio-mocking` → `desarrollo`
- **PR #39**: `desarrollo` → `main`

Todos los cambios fueron archivos **nuevos** (`create mode`), sin modificaciones (`modify`) ni eliminaciones (`delete`) sobre el código existente, garantizando cero impacto en la funcionalidad ya implementada del sistema.

### Conclusión
Se extrajo la lógica de negocio embebida en `procesar_registro.php` hacia una Entidad de Dominio con invariantes explícitas y un Application Service desacoplado de la persistencia mediante una interfaz (`IUsuarioRepository`), permitiendo probar el comportamiento de negocio de forma aislada y mediante Dobles de Prueba (Mocks), sin necesidad de una base de datos real.


