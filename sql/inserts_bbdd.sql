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


-- Personal extra (comprobar id's)
INSERT INTO persona (nombre_persona, apellido_persona) VALUES
('Sergio', 'Ramirez'),
('David', 'Palamos'),
('Maria', 'Alcino'),
('Hector', 'Haster'),
('Juan', 'Bastos'),
('Elena', 'Pastor');

INSERT INTO empleado (username_empleado, pwd_empleado, salario_empleado, DNI_empleado, persona_empleado, tipoEmpleado_empleado) VALUES
('sergio_ramirez', '$2a$12$.HyOilkTAI0jq6eZNmHgcOTqPqhao9JM7PcTRdkp3TLIRAQnjkAo2', 1300, '43482526S', 2, 1), -- pwd: QWEqwe123
('david_palamos', '$2a$12$.HyOilkTAI0jq6eZNmHgcOTqPqhao9JM7PcTRdkp3TLIRAQnjkAo2', 1350, '46442066S', 3, 1),
('maria_alcino', '$2a$12$.HyOilkTAI0jq6eZNmHgcOTqPqhao9JM7PcTRdkp3TLIRAQnjkAo2', 1400, '46481066S', 4, 1),
('hector_haster', '$2a$12$.HyOilkTAI0jq6eZNmHgcOTqPqhao9JM7PcTRdkp3TLIRAQnjkAo2', 1200, '43482926S', 5, 2),
('juan_bastos', '$2a$12$.HyOilkTAI0jq6eZNmHgcOTqPqhao9JM7PcTRdkp3TLIRAQnjkAo2', 1800, '46282226S', 6, 3),
('elena_pastor', '$2a$12$.HyOilkTAI0jq6eZNmHgcOTqPqhao9JM7PcTRdkp3TLIRAQnjkAo2', 1850, '43482526S', 7, 3);

-- SALAS
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(3, NULL), -- Sala 4
(3, NULL), -- Sala 5
(3, NULL), -- Sala 6
(3, NULL), -- Sala 7
(3, NULL), -- Sala 8
(3, NULL), -- Sala 9
(3, NULL); -- Sala 10



-- MESAS
-- Sala 4: 6 mesas
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(2, 4), (2, 4), (2, 4), (2, 4), (2, 4), (2, 4);

-- Sala 5: 3 mesas
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(2, 5), (2, 5), (2, 5);

-- Sala 6: 0 mesas (sin mesas)

-- Sala 7: 4 mesas
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(2, 7), (2, 7), (2, 7), (2, 7);

-- Sala 8: 2 mesas
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(2, 8), (2, 8);

-- Sala 9: 5 mesas
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(2, 9), (2, 9), (2, 9), (2, 9), (2, 9);

-- Sala 10: 1 mesa
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(2, 10);



-- SILLAS
-- Sala 4: 6 mesas, cada una con 4 sillas
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(1, 14), (1, 14), (1, 14), (1, 14), -- Mesa 1
(1, 15), (1, 15), (1, 15), (1, 15), -- Mesa 2
(1, 16), (1, 16), (1, 16), (1, 16), -- Mesa 3
(1, 17), (1, 17), (1, 17), (1, 17), -- Mesa 4
(1, 18), (1, 18), (1, 18), (1, 18), -- Mesa 5
(1, 19), (1, 19), (1, 19), (1, 19); -- Mesa 6

-- Sala 5: 3 mesas, cada una con 2 sillas
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(1, 20), (1, 20), -- Mesa 1
(1, 21), (1, 21), -- Mesa 2
(1, 22), (1, 22); -- Mesa 3

-- Sala 6: sin mesas (no hay sillas)

-- Sala 7: 4 mesas, alternando 3 y 2 sillas por mesa
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(1, 23), (1, 23), (1, 23), -- Mesa 1
(1, 24), (1, 24), -- Mesa 2
(1, 25), (1, 25), (1, 25), -- Mesa 3
(1, 26), (1, 26); -- Mesa 4

-- Sala 8: 2 mesas, ambas con 4 sillas
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(1, 27), (1, 27), (1, 27), (1, 27), -- Mesa 1
(1, 28), (1, 28), (1, 28), (1, 28); -- Mesa 2

-- Sala 9: 5 mesas, cada una con 6 sillas
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(1, 29), (1, 29), (1, 29), (1, 29), (1, 29), (1, 29), -- Mesa 1
(1, 30), (1, 30), (1, 30), (1, 30), (1, 30), (1, 30), -- Mesa 2
(1, 31), (1, 31), (1, 31), (1, 31), (1, 31), (1, 31), -- Mesa 3
(1, 32), (1, 32), (1, 32), (1, 32), (1, 32), (1, 32), -- Mesa 4
(1, 33), (1, 33), (1, 33), (1, 33), (1, 33), (1, 33); -- Mesa 5

-- Sala 10: 1 mesa, con 2 sillas
INSERT INTO recurso (tipoRecurso_recurso, recursoPadre_recurso) VALUES
(1, 34), (1, 34); -- Mesa 1




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