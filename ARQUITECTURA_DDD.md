# Documentación: DDD + Clean Architecture en Farmacia.1

## 🏗️ Estructura de Capas

El proyecto implementa **Domain-Driven Design (DDD)** combinado con **Clean Architecture**, separando responsabilidades en cuatro capas principales:

```
src/
├── Domain/                     # Capa de Dominio (Lógica de negocio pura)
│   ├── Entities/              # Entidades del dominio
│   │   ├── Patient.php        # Entidad Paciente
│   │   └── Appointment.php    # Entidad Cita
│   ├── ValueObjects/          # Objetos de Valor
│   │   ├── Email.php          # Email validado
│   │   ├── PhoneNumber.php    # Teléfono validado
│   │   └── PersonalId.php     # ID personal validado
│   └── Repositories/          # Interfaces de Repositorios
│       ├── PatientRepositoryInterface.php
│       └── AppointmentRepositoryInterface.php
│
├── Application/               # Capa de Aplicación (Casos de Uso)
│   ├── UseCases/             # Casos de uso del negocio
│   │   ├── CreatePatientUseCase.php
│   │   └── CreateAppointmentUseCase.php
│   └── DTOs/                 # Data Transfer Objects
│       ├── PatientDTO.php
│       ├── AppointmentDTO.php
│       └── CreatePatientRequestDTO.php
│
├── Infrastructure/           # Capa de Infraestructura (Implementación técnica)
│   ├── Database/            # Conexión a BD
│   │   └── Connection.php   # Singleton de conexión
│   └── Persistence/         # Implementación de Repositorios
│       ├── PatientRepository.php
│       └── AppointmentRepository.php
│
└── Presentation/            # Capa de Presentación (Endpoints)
    └── Controllers/
        ├── PatientController.php
        └── AppointmentController.php

tests/                        # Pruebas Unitarias
├── ValueObjectsTest.php
├── PatientEntityTest.php
├── AppointmentEntityTest.php
├── ExampleTest.php
└── MockeryExampleTest.php
```

## Características de la Arquitectura

### 1. **Capa de Dominio (Domain Layer)**
- **Entidades**: `Patient`, `Appointment` con lógica de negocio pura
- **Value Objects**: `Email`, `PhoneNumber`, `PersonalId` con validación
- **Interfaces de Repositorio**: Define contratos sin implementación
- **Independencia**: No tiene dependencias externas

**Ejemplo - Entidad Patient:**
```php
$patient = new Patient(
    id: 1,
    fullName: 'Juan Pérez',
    birthDate: new \DateTime('1990-05-15'),
    gender: 'M',
    phoneNumber: new PhoneNumber('1234567890'),
    email: new Email('juan@example.com')
);
```

### 2. **Capa de Aplicación (Application Layer)**
- **Casos de Uso**: `CreatePatientUseCase`, `CreateAppointmentUseCase`
- **DTOs**: Transferencia segura de datos entre capas
- **Lógica de Orquestación**: Coordina el dominio con la infraestructura

**Ejemplo - Caso de Uso:**
```php
$useCase = new CreatePatientUseCase($patientRepository);
$request = new CreatePatientRequestDTO(
    fullName: 'Juan Pérez',
    birthDate: '1990-05-15',
    gender: 'M',
    phoneNumber: '1234567890',
    email: 'juan@example.com'
);
$result = $useCase->execute($request);
```

### 3. **Capa de Infraestructura (Infrastructure Layer)**
- **Connection**: Singleton para conexión a Base de Datos
- **Repositorios**: Implementación concreta de interfaces del dominio
- **Acceso a Datos**: SQL con prepared statements (seguridad)

**Ejemplo - Repositorio:**
```php
$repository = new PatientRepository();
$repository->save($patient);
$retrieved = $repository->findById(1);
```

### 4. **Capa de Presentación (Presentation Layer)**
- **Controllers**: Punto de entrada de las solicitudes HTTP
- **JSON Response**: Respuestas estructuradas
- **Manejo de Errores**: Validación y excepciones

**Ejemplo - Controller:**
```php
$controller = new PatientController();
$controller->create(); // POST /api/patients
```

##  Ventajas de esta Arquitectura

| Ventaja | Descripción |
|---------|-------------|
| **Independencia de Frameworks** | El dominio no depende de frameworks externos |
| **Testabilidad** | Cada capa se puede probar independientemente |
| **Mantenibilidad** | Cambios en BD no afectan lógica de negocio |
| **Escalabilidad** | Fácil agregar nuevos casos de uso |
| **Separación de Responsabilidades** | Cada capa tiene una responsabilidad clara |
| **Reutilización de Código** | Casos de uso reutilizables en múltiples interfaces |

##  Casos de Uso Implementados

### CreatePatientUseCase
**Responsabilidades:**
- Validar datos del paciente
- Crear instancia de `Patient` con `Value Objects`
- Guardar en repositorio
- Retornar DTO con resultado

### CreateAppointmentUseCase
**Responsabilidades:**
- Validar datos de la cita
- Validar fecha futura
- Crear instancia de `Appointment`
- Guardar en repositorio
- Retornar DTO con resultado

##  Pruebas Unitarias

Se implementaron **15 pruebas unitarias** organizadas por capa:

```
✔ ValueObjectsTest (5 tests)
  - Validación de Email
  - Validación de PhoneNumber
  - Igualdad de Value Objects

✔ PatientEntityTest (3 tests)
  - Creación de Paciente
  - Actualización de Teléfono
  - Actualización de Email

✔ AppointmentEntityTest (5 tests)
  - Creación de Cita
  - Cancelación de Cita
  - Completación de Cita
  - Validaciones de negocio
```

##  Ejecución de Pruebas

```bash
# Ejecutar todas las pruebas
vendor\bin\phpunit

# Ejecutar con formato testdox
vendor\bin\phpunit --testdox

# Generar reporte de cobertura
vendor\bin\phpunit --coverage-html coverage-report
```

##  Flujo de Datos

```
Request HTTP (Controller)
         ↓
   Validación de entrada
         ↓
   Use Case (Orquestación)
         ↓
   Entidad de Dominio
         ↓
   Repositorio (Interface)
         ↓
   Persistencia (BD)
         ↓
   Response JSON
```

##  Inyección de Dependencias

El proyecto utiliza **inyección de dependencias constructor** para evitar acoplamiento:

```php
// En Controller
$repository = new PatientRepository();
$useCase = new CreatePatientUseCase($repository);
// El UseCase recibe la interfaz, no la implementación
```

##  Seguridad Implementada

-  **SQL Injection Prevention**: Prepared Statements
-  **Validación de Email**: Value Object
-  **Validación de Teléfono**: Value Object
-  **Validación de Fechas**: Entidades con excepciones
-  **Type Hints**: Tipado fuerte en PHP

##  Próximas Mejoras

1. Agregar Service Locator o Container de DI
2. Implementar eventos de dominio
3. Agregar especificaciones (filters) en repositorios
4. Implementar transacciones
5. Agregar logs y auditoría
6. Crear API REST completa

---

**Versión**: 1.0  
**Fecha**: 9 de mayo de 2026  
**Patrón**: DDD + Clean Architecture
