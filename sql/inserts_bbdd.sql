INSERT INTO tipoSala (nombre_tipoSala) VALUES
('terraza'),
('sala grande'),
('sala privada');

INSERT INTO tipoRecurso (nombre_tipoRecurso, tipoSala_tipoRecurso) VALUES
('silla', NULL),
('mesa', NULL),
('sala', 1),
('sala', 2),
('sala', 3);

INSERT INTO persona (nombre_persona, apellido_persona) VALUES
('Dylan', 'Castles');

INSERT INTO tipoEmpleado (nombre_tipoEmpleado) VALUES
('camarero'),
('personal mantenimiento'),
('cocinero'),
('gerente');

INSERT INTO empleado (username_empleado, pwd_empleado, salario_empleado, DNI_empleado, persona_empleado, tipoEmpleado_empleado) VALUES
('dylan_castles', '$2a$12$.HyOilkTAI0jq6eZNmHgcOTqPqhao9JM7PcTRdkp3TLIRAQnjkAo2', 2100, '46482026S', 1, 4); -- pwd: QWEqwe123

-- SALAS
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(3, NULL), -- Sala 4
(3, NULL), -- Sala 5
(3, NULL), -- Sala 6
(3, NULL), -- Sala 7
(3, NULL), -- Sala 8
(3, NULL), -- Sala 9
(3, NULL), -- Sala 10
(3, NULL), -- Sala 11
(3, NULL), -- Sala 12
(3, NULL); -- Sala 13


-- MESAS
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(2, 4), -- Mesa en Sala 4
(2, 4), -- Mesa en Sala 4
(2, 5), -- Mesa en Sala 5
(2, 5), -- Mesa en Sala 5
(2, 6), -- Mesa en Sala 6
(2, 6), -- Mesa en Sala 6
(2, 7), -- Mesa en Sala 7
(2, 7), -- Mesa en Sala 7
(2, 8), -- Mesa en Sala 8
(2, 8), -- Mesa en Sala 8
(2, 9), -- Mesa en Sala 9
(2, 9), -- Mesa en Sala 9
(2, 10), -- Mesa en Sala 10
(2, 10), -- Mesa en Sala 10
(2, 11), -- Mesa en Sala 11
(2, 11), -- Mesa en Sala 11
(2, 12), -- Mesa en Sala 12
(2, 12), -- Mesa en Sala 12
(2, 13); -- Mesa en Sala 13


-- SILLAS
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(1, 14), -- Silla en Sala 4 (Mesa 1)
(1, 14), -- Silla en Sala 4 (Mesa 2)
(1, 15), -- Silla en Sala 5 (Mesa 1)
(1, 15), -- Silla en Sala 5 (Mesa 2)
(1, 16), -- Silla en Sala 6 (Mesa 1)
(1, 16), -- Silla en Sala 6 (Mesa 2)
(1, 17), -- Silla en Sala 7 (Mesa 1)
(1, 17), -- Silla en Sala 7 (Mesa 2)
(1, 18), -- Silla en Sala 8 (Mesa 1)
(1, 18), -- Silla en Sala 8 (Mesa 2)
(1, 19), -- Silla en Sala 9 (Mesa 1)
(1, 19), -- Silla en Sala 9 (Mesa 2)
(1, 20), -- Silla en Sala 10 (Mesa 1)
(1, 20), -- Silla en Sala 10 (Mesa 2)
(1, 21), -- Silla en Sala 11 (Mesa 1)
(1, 21), -- Silla en Sala 11 (Mesa 2)
(1, 22), -- Silla en Sala 12 (Mesa 1)
(1, 22), -- Silla en Sala 12 (Mesa 2)
(1, 23), -- Silla en Sala 13 (Mesa 1)
(1, 23); -- Silla en Sala 13 (Mesa 2)



-- INSERT INTO ocupacion (fechaInicio_ocupacion, fechaFinal_ocupacion, detalles_ocupacion, empleado_ocupacion, cliente_ocupacion) VALUES
-- ('2024-12-10 15:00:00', '2024-12-10 17:00:00', ),
-- ('sala'),
-- ('sala'),
-- ('mesa', 1),
-- ('mesa', 1),
-- ('mesa', 1),
-- ('mesa', 2),
-- ('mesa', 2),
-- ('mesa', 3);

-- CREATE TABLE ocupacion(
--     id_ocupacion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     fechaInicio_ocupacion DATETIME NOT NULL,
--     fechaFinal_ocupacion DATETIME NOT NULL,
--     detalles_ocupacion VARCHAR(100) NULL,
--     empleado_ocupacion INT NOT NULL, -- FK
--     cliente_ocupacion INT NOT NULL -- FK
-- );