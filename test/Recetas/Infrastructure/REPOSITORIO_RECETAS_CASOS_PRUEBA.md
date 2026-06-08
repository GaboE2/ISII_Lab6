# Repositorio **Recetas** — `MysqliRecetaRepository`

| ID | Clase / método | Caso de prueba | Resultado esperado |
|----|----------------|----------------|---------------------|
| RC-R01 | `save` | INSERT parametrizado | `bind_param` con `iiiss` y cierre de statement |
| RC-R02 | `save` | Fallo en `prepare` | `RuntimeException` con mensaje de preparación |
