# Dominio **Recetas / prescripción** — `LineaReceta`

| ID | Clase / método | Caso de prueba | Valores | Resultado esperado |
|----|----------------|----------------|---------|---------------------|
| RC-D01 | `LineaReceta::__construct` | Cantidad y fecha válidas | cantidad con espacios, fecha `2026-05-14` | `cantidadPreinscrita()` sin espacios laterales; fecha conservada |
| RC-D02 | `LineaReceta::__construct` | Invariante cantidad no vacía | cantidad `"   "` | `InvalidArgumentException` |
| RC-D03 | `LineaReceta::__construct` | Invariante fecha `Y-m-d` | fecha `2026-13-40` | `InvalidArgumentException` |
