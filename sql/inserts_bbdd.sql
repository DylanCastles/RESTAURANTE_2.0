INSERT INTO tipoRecurso (nombre_tipoRecurso) VALUES
('silla'),
('mesa'),
('sala');

INSERT INTO tipoEmpleado (nombre_tipoEmpleado) VALUES
('camarero'),
('personal mantenimiento'),
('cocinero'),
('gerente');

INSERT INTO persona (nombre_persona, apellido_persona) VALUES
('Dylan', 'Castles');

INSERT INTO empleado (username_empleado, pwd_empleado, salario_empleado, DNI_empleado, persona_empleado, tipoEmpleado_empleado) VALUES
('dylan_castles', '$2a$12$.HyOilkTAI0jq6eZNmHgcOTqPqhao9JM7PcTRdkp3TLIRAQnjkAo2', 2100, '46482026S', 1, 4); -- pwd: QWEqwe123