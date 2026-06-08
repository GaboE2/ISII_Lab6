-- Estructura básica para pruebas de Farmacia Hospital
CREATE TABLE IF NOT EXISTS usuario (
    ID_Usuario INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_usuario VARCHAR(100),
    Apellido_usuario VARCHAR(100),
    Correo_usuario VARCHAR(100),
    Contraseña_usuario VARCHAR(255),
    ID_Rol INT
);

CREATE TABLE IF NOT EXISTS doctor (
    ID_Doctor INT PRIMARY KEY,
    Nombre_doctor VARCHAR(100),
    Primer_apellido_doctor VARCHAR(100),
    Segundo_apellido_doctor VARCHAR(100),
    Especialidad VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS paciente (
    ID_Paciente INT PRIMARY KEY,
    Nombre_paciente VARCHAR(100),
    Primer_apellido_paciente VARCHAR(100),
    Segundo_apellido_paciente VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS medicamento (
    ID_Medicamento INT PRIMARY KEY,
    Nombre_medicamento VARCHAR(100),
    Stock_medicamento INT DEFAULT 10,
    Precio DECIMAL(10,2)
);

CREATE TABLE IF NOT EXISTS pedido_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    medicamento_id INT,
    cantidad INT,
    fecha_pedido DATETIME
);