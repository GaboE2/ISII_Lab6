#insertar medicamentos a Base de Datos
USE farmacia;

ALTER TABLE medicamento MODIFY ID_Medicamento INT AUTO_INCREMENT;

INSERT INTO medicamento (Nombre_Medicamento, ID_Clase_Medicamento, Clase_Medicamento, Fecha_vencimiento, Stock_medicamento, Precio_medicamento) VALUES
('Paracetamol', 1, 'Analgesico', '2025-12-31', 100, 10.00),
('Amoxicilina', 2, 'Antibiotico', '2024-08-20', 200, 12.90);


INSERT INTO medicamento (Nombre_Medicamento, ID_Clase_Medicamento, Clase_Medicamento, Fecha_vencimiento, Stock_medicamento, Precio_medicamento) VALUES
('Ibuprofeno', 3, 'Antiinflamatorio', '2025-06-15', 150, 9.00),
('Omeprazol', 4, 'Antiulceroso', '2024-11-05', 180, 16.00),
('Loratadina', 5, 'Antihistaminico', '2025-03-10', 120, 4.00),
('Metformina', 6, 'Antidiabetico', '2024-07-22', 300, 24.50),
('Enalapril', 7, 'Antihipertensivo', '2025-01-30', 133, 6.00),
('Simvastatina', 8, 'Hipolipemiante', '2024-10-14', 160, 37.50),
('Furosemida', 9, 'Diuretico', '2025-09-30', 90, 10.00),
('Clopidrogel', 10, 'Antiplaquetario', '2024-12-15', 75, 15.30);