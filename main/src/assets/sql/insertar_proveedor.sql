USE farmacia;

ALTER TABLE proveedor MODIFY Contacto_proveedor BIGINT;

INSERT INTO Proveedor (ID_Proveedor, Nombre_proveedor, Contacto_proveedor, Direccion_proveedor) VALUES
(11, 'Proveedora Farmacéutica Nacional', 112233445, 'Av. Libertador 123, Ciudad Principal'),
(12, 'Productos Químicos y Equipos Médicos', 998877665, 'Calle 10 # 45-67, Otra Ciudad'),
(13, 'Distribuciones Hospitalarias SL', 667788990, 'Av. Central 456, Ciudad Capital'),
(14, 'Equipos Médicos del Norte', 889900112, 'Carrera 7 # 89-10, Otra Ciudad'),
(15, 'Suministros Médicos Especializados', 554433221, 'Av. Sur 34 # 56-78, Ciudad Principal'),
(16, 'Distribuidora de Material Sanitario', 334455667, 'Plaza Mayor 1, Otra Ciudad'),
(17, 'Laboratorios Farmacéuticos Modernos', 112233445, 'Calle Real 789, Ciudad Capital'),
(18, 'Equipos de Salud Integral', 998877665, 'Av. Central 234, Otra Ciudad'),
(19, 'Productos Sanitarios Globales', 667788990, 'Carrera 5 # 67-89, Ciudad Principal'),
(20, 'Distribuidora de Equipos Médicos Avanzados', 889900112, 'Av. Libertador 567, Otra Ciudad');