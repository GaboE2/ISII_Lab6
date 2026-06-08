# Capa de servicios de aplicación — **Reducir stock** (`ReducirStockHandler`)

Módulo: **Medicamentos** — caso de uso que orquesta el agregado y el puerto `MedicamentoRepository`.

## Especificación de casos de prueba

### Pruebas unitarias (mock del repositorio — Mockery)

| ID | Clase / método | Caso de prueba | Valores de prueba | Resultado esperado |
|----|-----------------|----------------|-------------------|---------------------|
| SA-U01 | `ReducirStockHandler::handle` | Flujo feliz: carga, dominio, persistencia | id `5`, stock `4`, retiro `3` | `findById(5)` una vez; `save` con stock `1` |
| SA-U02 | `ReducirStockHandler::handle` | Medicamento inexistente | `findById` → `null` | `InvalidArgumentException` ("Medicamento no encontrado") |
| SA-U03 | `ReducirStockHandler::handle` | Stock insuficiente (dominio) | stock `2`, retiro `5` | `InsufficientStockException`; **no** se llama `save` |

### Pruebas de integración (doble en memoria del repositorio)

| ID | Clase / método | Caso de prueba | Valores de prueba | Resultado esperado |
|----|-----------------|----------------|-------------------|---------------------|
| SA-I01 | `ReducirStockHandler::handle` + `InMemoryMedicamentoRepository` | Handler + repositorio real (en memoria) | id `10`, stock inicial `100`, retiro `15` | Tras `handle`, `findById` devuelve stock `85` |
| SA-I02 | `ReducirStockHandler::handle` + memoria | Sin semilla para el id | id `99`, cualquier cantidad | `InvalidArgumentException` |

## xUnit (PHPUnit)

- **Test Suites:** `aplicacion-medicamentos-unit`, `aplicacion-medicamentos-integracion`
- **Assertions, SetUp, TearDown:** en cada `TestCase`
- **Mocking:** Mockery en unitarias; repositorio concreto en integración

## Ejecución

```bash
php vendor/bin/phpunit --testsuite aplicacion-medicamentos-unit
php vendor/bin/phpunit --testsuite aplicacion-medicamentos-integracion
```

En una sola invocación (unitarias + integración), usar la ruta del módulo (PHPUnit no permite repetir `--testsuite` en la misma línea):

```bash
php vendor/bin/phpunit test/Medicamentos/Application
```
