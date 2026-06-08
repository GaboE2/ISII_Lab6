# Módulo de dominio: **Medicamentos** — Agregado `Medicamento`

Casos de prueba unitarios (comportamiento del agregado e **invariantes** de objetos de valor relacionados: `MedicamentoId`, `Cantidad`).

## a. Especificación de casos de prueba

| ID | Clase / método bajo prueba | Caso de prueba | Valores de prueba | Resultado esperado |
|----|---------------------------|----------------|-------------------|---------------------|
| CP-01 | `Medicamento::retirarUnidades` | Retiro válido reduce el stock | stock inicial `10`, retiro `3` | Stock resultante `7` |
| CP-02 | `Medicamento::retirarUnidades` | Retiro mayor al stock disponible | stock `2`, retiro `5` | Se lanza `InsufficientStockException` |
| CP-03 | `Medicamento::retirarUnidades` | Retiro límite deja stock en cero | stock `4`, retiro `4` | Stock resultante `0` |
| CP-04 | `Medicamento::__construct` | Invariante: stock no negativo | `MedicamentoId` válido, nombre `"X"`, stock `-1` | Se lanza `InvalidArgumentException` |
| CP-05 | `MedicamentoId::fromInt` | Invariante: id estrictamente positivo | id `0` | Se lanza `InvalidArgumentException` |
| CP-06 | `Cantidad::fromInt` | Invariante: al menos una unidad | unidades `0` | Se lanza `InvalidArgumentException` |

## Referencia de implementación

- **Test Suite (PHPUnit):** `dominio-medicamentos` → `test/Medicamentos/Domain/`
- **Test Case:** clases `MedicamentoTest`, `ValorDeDominioMedicamentosTest`
- **Assertions:** `assertSame`, `expectException`, `expectExceptionMessage`
- **SetUp / TearDown:** preparación de `MedicamentoId` común y cierre ordenado por test
