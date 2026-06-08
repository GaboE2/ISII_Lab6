#Insertando suplementos en la Base de Datos
USE farmacia;

ALTER TABLE suplemento
CHANGE COLUMN stock_suplmento stock_suplemento INT;
INSERT INTO suplemento (ID_Suplemento, Nombre_Suplemento, Stock_suplemento, Precio_suplemento, ID_Departamento) VALUES
    (101, 'Vitamina D', 100, 50.90, 1234),
    (205, 'Omega-3', 120, 73.80, 2345),
    (309, 'Multivitaminico', 80, 75.90, 2356),
    (413, 'Calcio', 150, 47.90, 3456),
    (527, 'Magnesio', 90, 94.90, 4522),
    (632, 'Zinc', 200, 39.90, 4567),
    (748, 'Vitamina B12', 110, 59.90, 5678),
    (859, 'Probioticos', 70, 93.90, 6789),
    (960, 'Vitamina C', 180, 29.80, 7890),
    (105, 'Colageno', 130, 34.90, 7891);
