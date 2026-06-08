CREATE DATABASE farmacia;

USE farmacia;
CREATE TABLE Departamento
(
    ID_Departamento INTEGER PRIMARY KEY,
    Nombre_Departamento VARCHAR(255) ,
    Edificio VARCHAR(255),
    Presupuesto FLOAT
);

CREATE TABLE Doctor (
    ID_Doctor INTEGER PRIMARY KEY,
    Nombre_doctor VARCHAR(255) ,
    Primer_apellido_doctor VARCHAR(255) ,
    Segundo_apellido_doctor VARCHAR(255) ,
    Especialidad VARCHAR(255) ,
    Edad_Doctor INTEGER,
    Fecha_nacimiento_doctor DATE ,
    ID_Departamento INTEGER
);

CREATE TABLE Paciente (
    ID_Paciente INTEGER PRIMARY KEY ,
    Nombre_paciente VARCHAR(255) ,
    Primer_apellido_paciente VARCHAR(255) ,
    Segundo_apellido_paciente VARCHAR(255) ,
    Genero_paciente ENUM('Masculino','Femenino','Otro'),
    Edad_paciente INTEGER DEFAULT NULL,
    Fecha_nacimiento_paciente DATE ,
    Correo_paciente VARCHAR(255) ,
    Dirección_paciente VARCHAR(255) ,
    Historial_médico MEDIUMTEXT ,
    ID_Departamento INTEGER 
);

CREATE TABLE Telefono_Paciente(
	  ID_Paciente INTEGER,
    telefono_paciente INTEGER,
    PRIMARY KEY(ID_Paciente,telefono_paciente)
);

CREATE TABLE Suplemento(
	ID_Suplemento INT PRIMARY KEY AUTO_INCREMENT,
    Nombre_Suplemento VARCHAR(255),
    Stock_suplmento INTEGER,
    Precio_suplemento FLOAT,
    ID_Departamento INTEGER
);

CREATE TABLE Historial_Medico(
	ID_Historial_Medico INT PRIMARY KEY AUTO_INCREMENT,
    Detalles_Historial MEDIUMTEXT,
    Fecha_registro DATE,
    ID_Paciente INTEGER
);

CREATE TABLE Preinscripcion(
	ID_Preincripcion INTEGER,
    ID_Paciente INTEGER,
    ID_Doctor INTEGER,
    ID_Medicamento INTEGER,
    Fecha_emision DATE,
    Dosis VARCHAR(50),
    Instrucciones MEDIUMTEXT,
    PRIMARY KEY(ID_Preincripcion,ID_Paciente,ID_Doctor,ID_Medicamento)
);

CREATE TABLE Consulta(
	ID_Consulta INTEGER,
    ID_Paciente INTEGER,
    ID_Doctor INTEGER,
    Fecha_consulta DATE,
    Motivo_consulta VARCHAR(255),
    Diagnostico MEDIUMTEXT,
    PRIMARY KEY(ID_Consulta,ID_Paciente,ID_Doctor)
);

CREATE TABLE Cita(
	ID_Cita INTEGER,
    ID_Paciente INTEGER,
    ID_Doctor INTEGER,
    Fecha_cita DATE,
    Hora_inicio_cita TIME,
    Hora_fin_cita TIME,
    PRIMARY KEY(ID_Cita,ID_Paciente,ID_Doctor)
);

CREATE TABLE Receta(
	ID_Receta INTEGER,
    ID_Consulta INTEGER,
    ID_Medicamento INTEGER,
    Cantidad_preinscrita VARCHAR(255),
    Fecha_receta DATE,
    PRIMARY KEY(ID_Receta,ID_Consulta,ID_Medicamento)
);

CREATE TABLE Clase_Medicamento(
    ID_Clase_Medicamento INTEGER PRIMARY KEY,
    Nombre_clase_Medicamento VARCHAR(255)
);

CREATE TABLE Medicamento(
    ID_Medicamento INTEGER PRIMARY KEY,
    Nombre_Medicamento VARCHAR(255),
    ID_Clase_Medicamento INTEGER,
    Clase_Medicamento VARCHAR(255),
    Fecha_vencimiento DATE,
    Stock_medicamento INTEGER,
    Precio_medicamento FLOAT
);

CREATE TABLE Horario(
	ID_Horario INTEGER PRIMARY KEY,
    Dia DATE,
    Hora_inicio_horario TIME,
    Hora_fin_horario TIME
);

CREATE TABLE tiene(
    ID_Horarios INTEGER,
    ID_Doctor INTEGER,
	PRIMARY KEY(ID_Horarios,ID_Doctor)
);

CREATE TABLE Proveedor(
	ID_Proveedor INTEGER PRIMARY KEY,
    Nombre_proveedor VARCHAR(255),
    Contacto_proveedor INTEGER,
    Direccion_proveedor MEDIUMTEXT
);

CREATE TABLE Pedido(
	ID_Pedido INTEGER,
    ID_Proveedor INTEGER,
    Fecha_pedido DATE,
    ID_Medicamento INTEGER,
    Cantidad INTEGER,
    Estado_Pedido ENUM('Pendiente','Enviado','Entregado','Cancelado'),
    PRIMARY KEY(ID_Pedido,ID_Proveedor,ID_Medicamento)
);

CREATE TABLE usuario(
	ID_Usuario INTEGER PRIMARY KEY,
    Nombre_usuario VARCHAR(255),
    Apelido_usuario VARCHAR(255),
    Correo_usuario VARCHAR(255) NOT NULL UNIQUE,
    Contraseña_usuario VARCHAR(255),
    ID_rol INTEGER
);

CREATE TABLE rol(
	ID_rol INTEGER PRIMARY KEY AUTO_INCREMENT,
    Nombre_rol ENUM('Administrador','Doctor','Personal','Cliente')
);

ALTER TABLE doctor ADD FOREIGN KEY (ID_Departamento) REFERENCES departamento (ID_Departamento);
ALTER TABLE paciente ADD FOREIGN KEY (ID_Departamento) REFERENCES departamento (ID_Departamento);
ALTER TABLE suplemento ADD FOREIGN KEY (ID_Departamento) REFERENCES departamento (ID_Departamento);
ALTER TABLE historial_medico ADD FOREIGN KEY (ID_Paciente) REFERENCES paciente (ID_Paciente);
ALTER TABLE telefono_paciente ADD FOREIGN KEY (ID_Paciente) REFERENCES paciente (ID_Paciente);

ALTER TABLE preinscripcion ADD FOREIGN KEY (ID_Paciente) REFERENCES paciente (ID_Paciente);
ALTER TABLE preinscripcion ADD FOREIGN KEY (ID_Doctor) REFERENCES doctor (ID_Doctor);
ALTER TABLE preinscripcion ADD FOREIGN KEY (ID_Medicamento) REFERENCES medicamento (ID_Medicamento);

ALTER TABLE consulta ADD FOREIGN KEY (ID_Paciente) REFERENCES paciente (ID_Paciente);
ALTER TABLE consulta ADD FOREIGN KEY (ID_Doctor) REFERENCES doctor (ID_Doctor);

ALTER TABLE cita ADD FOREIGN KEY (ID_Paciente) REFERENCES paciente (ID_Paciente);
ALTER TABLE cita ADD FOREIGN KEY (ID_Doctor) REFERENCES doctor (ID_Doctor);

ALTER TABLE receta ADD FOREIGN KEY (ID_Consulta) REFERENCES consulta (ID_Consulta);
ALTER TABLE receta ADD FOREIGN KEY (ID_Medicamento) REFERENCES medicamento (ID_Medicamento);

ALTER TABLE medicamento ADD FOREIGN KEY (ID_Clase_medicamento) REFERENCES clase_medicamento (ID_Clase_medicamento);

ALTER TABLE tiene ADD FOREIGN KEY (ID_Horarios) REFERENCES horario (ID_Horario);
ALTER TABLE tiene ADD FOREIGN KEY (ID_Doctor) REFERENCES doctor (ID_Doctor);

ALTER TABLE pedido ADD FOREIGN KEY (ID_Proveedor) REFERENCES proveedor (ID_Proveedor);
ALTER TABLE pedido ADD FOREIGN KEY (ID_Medicamento) REFERENCES medicamento (ID_Medicamento);

ALTER TABLE usuario ADD FOREIGN KEY (ID_Rol) REFERENCES rol(ID_Rol);

