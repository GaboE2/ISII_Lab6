# Módulo **repositorio**: `MysqliMedicamentoRepository`

Adaptador que implementa el puerto `MedicamentoRepository` (persistencia MySQL / `medicamento`).

## a. Especificación de casos de prueba

| ID | Clase / método | Caso de prueba | Valores de prueba | Resultado esperado |
|----|----------------|----------------|-------------------|---------------------|
| RP-01 | `MysqliMedicamentoRepository::findById` | Mapeo de fila SQL al agregado | Fila id `9`, nombre `Omeprazol`, stock `42` | `Medicamento` con mismos id, nombre y stock |
| RP-02 | `MysqliMedicamentoRepository::findById` | Sin coincidencias en BD | `fetch_assoc` → `false` | `null` |
| RP-03 | `MysqliMedicamentoRepository::findById` | Fallo al preparar consulta | `prepare` → `false`, `error` no vacío | `RuntimeException` mensaje preparación |
| RP-04 | `MysqliMedicamentoRepository::save` | Persistencia de stock e id en UPDATE | Agregado id `3`, stock `11` | `bind_param` con `'ii'`, stock `11`, id `3`; `close` invocado |

## b. xUnit (PHPUnit)

- **Test Suite:** `repositorio-medicamentos` (`phpunit.xml.dist`).
- **Test Case:** `MysqliMedicamentoRepositoryTest`.
- **Assertions:** `assertSame`, `assertNotNull`, `assertNull`, `assertTrue`, `expectException`, `expectExceptionMessage`.
- **SetUp / TearDown:** explícitos + cierre de expectativas Mockery vía `MockeryPHPUnitIntegration`.

## Ejecución

```bash
php vendor/bin/phpunit --testsuite repositorio-medicamentos
```
