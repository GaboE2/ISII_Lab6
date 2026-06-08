#Insertar doctores a la base de datos

USE farmacia;

INSERT INTO Doctor (ID_Doctor, Nombre_doctor, Primer_apellido_doctor, Segundo_apellido_doctor, Especialidad, Edad_Doctor, Fecha_nacimiento_doctor, ID_Departamento) VALUES
-- Cardiología
(12345678, 'Juan', 'García', 'Martínez', 'Cardiología', 45, '1979-05-15', 4522),
(19202122, 'Jorge', 'Martínez', 'Fernández', 'Cardiología', 47, '1976-04-05', 4522),
(20222324, 'Diego', 'Paredes', 'Navarro', 'Cardiología', 50, '1973-12-23', 4522),
(21232425, 'Lucía', 'Ponce', 'Rivas', 'Cardiología', 44, '1980-06-01', 4522),
(22242526, 'Ricardo', 'Saavedra', 'Campos', 'Cardiología', 41, '1983-01-11', 4522),

-- Dermatología
(23456789, 'María', 'López', 'Hernández', 'Dermatología', 38, '1985-08-20', 2356),
(20212223, 'Carmen', 'Ruiz', 'Gómez', 'Dermatología', 41, '1982-07-20', 2356),
(23242527, 'Elisa', 'Palacios', 'Garrido', 'Dermatología', 42, '1981-05-16', 2356),
(24252628, 'Tomás', 'Salazar', 'Iglesias', 'Dermatología', 36, '1987-03-25', 2356),
(25262729, 'Beatriz', 'Vargas', 'Castillo', 'Dermatología', 39, '1984-08-14', 2356),

-- Neurología
(34567890, 'Pedro', 'Martínez', 'Rodríguez', 'Neurología', 50, '1973-03-10', 5678),
(26272830, 'Mónica', 'Rojas', 'Moreno', 'Neurología', 48, '1975-07-29', 5678),
(27282931, 'Javier', 'Cano', 'Luna', 'Neurología', 46, '1977-02-18', 5678),
(28293032, 'Pilar', 'Giménez', 'Ortiz', 'Neurología', 49, '1974-11-22', 5678),
(29303133, 'Gonzalo', 'Navarro', 'Reyes', 'Neurología', 44, '1980-04-09', 5678),

-- Pediatría
(45678901, 'Ana', 'Pérez', 'González', 'Pediatría', 33, '1990-07-25', 7890),
(18192021, 'Paula', 'López', 'Martínez', 'Pediatría', 32, '1991-12-10', 7890),
(30313234, 'Gloria', 'Ríos', 'Silva', 'Pediatría', 37, '1986-09-28', 7890),
(31323335, 'Vicente', 'Vega', 'García', 'Pediatría', 34, '1989-05-21', 7890),
(32333436, 'Clara', 'Santos', 'Paredes', 'Pediatría', 38, '1985-11-03', 7890),

-- Oftalmología
(56789012, 'Luis', 'Sánchez', 'López', 'Oftalmología', 40, '1983-11-30', 1234),
(16171819, 'Isabel', 'Díaz', 'Ramírez', 'Oftalmología', 39, '1984-09-15', 1234),
(33343537, 'Rafael', 'Pérez', 'Torres', 'Oftalmología', 42, '1981-07-07', 1234),
(34353638, 'Dolores', 'Cabrera', 'Mendoza', 'Oftalmología', 41, '1982-08-11', 1234),
(35363739, 'Esteban', 'Núñez', 'Delgado', 'Oftalmología', 38, '1985-01-19', 1234),

-- Ginecología
(67890123, 'Marta', 'Ramírez', 'Jiménez', 'Ginecología', 37, '1986-09-17', 9012),
(36373840, 'Nuria', 'Fernández', 'Romero', 'Ginecología', 35, '1988-04-02', 9012),
(37383941, 'Ángel', 'Rubio', 'Vargas', 'Ginecología', 39, '1984-12-24', 9012),
(38394042, 'Belén', 'Mora', 'Ríos', 'Ginecología', 36, '1987-07-11', 9012),
(39404143, 'Fernando', 'Muñoz', 'Castro', 'Ginecología', 38, '1985-03-18', 9012),

-- Psiquiatría
(78901234, 'Carlos', 'Torres', 'Martín', 'Psiquiatría', 42, '1981-04-12', 3456),
(40414244, 'Celia', 'Ortiz', 'Jiménez', 'Psiquiatría', 44, '1980-06-26', 3456),
(41424345, 'Rodrigo', 'Gil', 'Rey', 'Psiquiatría', 45, '1979-09-30', 3456),
(42434446, 'Helena', 'Campos', 'López', 'Psiquiatría', 41, '1982-10-12', 3456),
(43444547, 'Sergio', 'Vega', 'Herrera', 'Psiquiatría', 43, '1980-02-21', 3456),

-- Ortopedia
(89012345, 'Laura', 'Ruiz', 'Fernández', 'Ortopedia', 46, '1977-06-22', 7891),
(17181920, 'Antonio', 'González', 'Sánchez', 'Ortopedia', 48, '1975-05-18', 7891),
(44454648, 'Félix', 'Guerrero', 'Santos', 'Ortopedia', 40, '1983-11-13', 7891),
(45464749, 'Rocío', 'Lara', 'Méndez', 'Ortopedia', 37, '1986-04-27', 7891),
(46474850, 'Oscar', 'Benítez', 'Peña', 'Ortopedia', 42, '1981-08-19', 7891),

-- Radiología
(90123456, 'José', 'Vázquez', 'Ruiz', 'Radiología', 39, '1984-10-05', 2345),
(47484951, 'Inés', 'Cruz', 'Ortega', 'Radiología', 38, '1985-03-14', 2345),
(48495052, 'Ramón', 'Sierra', 'Rubio', 'Radiología', 41, '1982-01-08', 2345),
(49505153, 'Sara', 'Duarte', 'Álvarez', 'Radiología', 40, '1983-11-05', 2345),
(50515254, 'Hugo', 'Lozano', 'Prieto', 'Radiología', 37, '1986-08-22', 2345),

-- Oncología
(10111213, 'Sofía', 'Gómez', 'Díaz', 'Oncología', 44, '1979-02-14', 6789),
(51525355, 'Miguel', 'Nieto', 'Blanco', 'Oncología', 45, '1978-09-30', 6789),
(52535456, 'Victoria', 'Santos', 'Montes', 'Oncología', 46, '1977-11-11', 6789),
(53545557, 'Eduardo', 'Rey', 'Márquez', 'Oncología', 47, '1976-07-03', 6789),
(54555658, 'Carmen', 'Sánchez', 'Campos', 'Oncología', 43, '1980-03-16', 6789),

-- Urología
(11121314, 'Pablo', 'Flores', 'Morales', 'Urología', 35, '1988-12-01', 8901),
(55565759, 'Patricia', 'Álvarez', 'Ibáñez', 'Urología', 36, '1987-02-26', 8901),
(56575860, 'Daniel', 'Serrano', 'Martínez', 'Urología', 38, '1985-10-18', 8901),
(57585961, 'Silvia', 'Ramos', 'Vidal', 'Urología', 39, '1984-05-30', 8901),
(58596062, 'Alberto', 'Moreno', 'Díaz', 'Urología', 37, '1986-07-21', 8901),

-- Endocrinología
(12131415, 'Elena', 'Cruz', 'Ortiz', 'Endocrinología', 41, '1982-03-28', 4567),
(59606163, 'Luis', 'Hernández', 'Molina', 'Endocrinología', 42, '1981-11-19', 4567),
(60616264, 'Natalia', 'Fuentes', 'Moreno', 'Endocrinología', 39, '1984-01-14', 4567),
(61626365, 'Raúl', 'Gómez', 'Lara', 'Endocrinología', 40, '1983-08-09', 4567),
(62636466, 'Irene', 'Medina', 'Pascual', 'Endocrinología', 37, '1986-04-04', 4567),

-- Neumología
(13141516, 'Francisco', 'Reyes', 'Gutiérrez', 'Neumología', 47, '1976-08-09', 8902),
(63646567, 'María', 'Díaz', 'Soler', 'Neumología', 46, '1977-09-14', 8902),
(64656668, 'Antonio', 'Vázquez', 'Garrido', 'Neumología', 45, '1978-06-28', 8902),
(65666769, 'Raquel', 'Molina', 'Ramos', 'Neumología', 44, '1979-10-05', 8902),
(66676870, 'Miguel', 'Sanz', 'Herrera', 'Neumología', 42, '1981-02-17', 8902),

-- Hematología
(14151617, 'Rosa', 'Mendoza', 'Chávez', 'Hematología', 36, '1987-07-03', 7890),
(67686971, 'Carlos', 'Mena', 'Navarro', 'Hematología', 35, '1988-03-11', 7890),
(68697072, 'Patricia', 'Gil', 'Martínez', 'Hematología', 37, '1986-06-22', 7890),
(69707173, 'Juan', 'Ramos', 'Romero', 'Hematología', 38, '1985-09-29', 7890),
(70717274, 'Lourdes', 'Vega', 'González', 'Hematología', 39, '1984-11-13', 7890),

