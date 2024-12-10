CREATE DATABASE restaurante_bbdd;
USE restaurante_bbdd;

CREATE TABLE ocupacion(
    id_ocupacion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fechaInicio_ocupacion DATETIME NOT NULL,
    fechaFinal_ocupacion DATETIME NOT NULL,
    detalles_ocupacion VARCHAR(100) NULL,
    empleado_ocupacion INT NOT NULL, -- FK
    cliente_ocupacion INT NOT NULL -- FK
);
CREATE TABLE recurso(
    id_recurso INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tipoRecurso_recurso INT NOT NULL, -- FK
    recursoPadre_recurso INT NULL -- FK
);
CREATE TABLE tipoSala(
    id_tipoSala INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_tipoSala VARCHAR(50) NOT NULL
);
CREATE TABLE tipoRecurso(
    id_tipoRecurso INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_tipoRecurso VARCHAR(50) NOT NULL,
    tipoSala_tipoRecurso INT NULL
);
CREATE TABLE persona(
    id_persona INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_persona VARCHAR(30) NOT NULL,
    apellido_persona VARCHAR(60) NOT NULL
);
CREATE TABLE tipoEmpleado(
    id_tipoEmpleado INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_tipoEmpleado VARCHAR(50) NOT NULL
);
CREATE TABLE cliente(
    id_cliente INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tel_cliente INT NOT NULL,
    persona_cliente INT NOT NULL  -- FK
);
CREATE TABLE empleado(
    id_empleado INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username_empleado VARCHAR(100) NOT NULL,
    pwd_empleado CHAR(60) NOT NULL,
    salario_empleado INT NULL,
    DNI_empleado CHAR(9) NOT NULL,
    persona_empleado INT NOT NULL, -- FK
    tipoEmpleado_empleado INT NOT NULL -- FK
);
CREATE TABLE recursoOcupacion(
    id_recursoOcupacion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sillas_ocupacion INT NOT NULL,
    ocupacion_recursoOcupacion INT NOT NULL, -- FK
    recurso_recursoOcupacion INT NOT NULL -- FK
);
ALTER TABLE
    recurso ADD CONSTRAINT recurso_tiporecurso_recurso_foreign FOREIGN KEY(tipoRecurso_recurso) REFERENCES tipoRecurso(id_tipoRecurso);
ALTER TABLE
    empleado ADD CONSTRAINT empleado_tipoempleado_empleado_foreign FOREIGN KEY(tipoEmpleado_empleado) REFERENCES tipoEmpleado(id_tipoEmpleado);
ALTER TABLE
    empleado ADD CONSTRAINT empleado_persona_empleado_foreign FOREIGN KEY(persona_empleado) REFERENCES persona(id_persona);
ALTER TABLE
    recursoOcupacion ADD CONSTRAINT recursoocupacion_recurso_recursoocupacion_foreign FOREIGN KEY(recurso_recursoOcupacion) REFERENCES recurso(id_recurso);
ALTER TABLE
    recurso ADD CONSTRAINT recurso_recursopadre_recurso_foreign FOREIGN KEY(recursoPadre_recurso) REFERENCES recurso(id_recurso);
ALTER TABLE
    tipoRecurso ADD FOREIGN KEY(tipoSala_tipoRecurso) REFERENCES tipoSala(id_tipoSala);
ALTER TABLE
    cliente ADD CONSTRAINT cliente_persona_cliente_foreign FOREIGN KEY(persona_cliente) REFERENCES persona(id_persona);
ALTER TABLE
    ocupacion ADD CONSTRAINT ocupacion_cliente_ocupacion_foreign FOREIGN KEY(cliente_ocupacion) REFERENCES persona(id_persona);
ALTER TABLE
    ocupacion ADD CONSTRAINT ocupacion_empleado_ocupacion_foreign FOREIGN KEY(empleado_ocupacion) REFERENCES persona(id_persona);
ALTER TABLE
    recursoOcupacion ADD CONSTRAINT recursoocupacion_ocupacion_recursoocupacion_foreign FOREIGN KEY(ocupacion_recursoOcupacion) REFERENCES ocupacion(id_ocupacion);