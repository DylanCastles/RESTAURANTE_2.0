#  🍽️ Sistema de Reserva de Mesas en un Restaurante 🍽️ 

##  📋 Proyecto PJ 01: TRANSVERSAL

#### 🎯 Objetivo
Este proyecto tiene como objetivo la creación desde cero de un sitio web integrado en la intranet de un restaurante para la gestión de reservas de mesas. Este sistema permitirá a los camareros gestionar y visualizar en tiempo real la disponibilidad de mesas y sillas en el restaurante para así poder de manera dinámica conseguir sitio.

#### ⏳ Duración
La duración aproximada del proyecto es de: **30 horas**

####  🏛️ Estructura del Restaurante
El restaurante cuenta con diferentes espacios, específicamente:
- **3 terrazas**
- **2 comedores**
- **4 salas privadas**

#### ⚙️ Funcionamiento de la Aplicación
Los usuarios de la aplicación serán los **camareros del restaurante**, quienes deben poder ver:
- La disponibilidad de mesas, donde las mesas pueden estar ocupadas o libres y reservarlas.
- Las sillas que puede tener cada espacio reservado, es decir, cada mesa.

El sistema permitirá que los camareros marquen las mesas como ocupadas cuando lleguen los clientes, indicando que cada mesa estará ocupada o libre en tiempo real, sin necesidad de reservarla para un día y hora específicos. Esto hará que sea dinámico el hecho de poder ver la disponiblidad que tenemos en el restaurante

####  👥 Gestión de Usuarios y Recursos
Cada camarero debe iniciar sesión en el sistema (login) antes de marcar una mesa como ocupada o liberarla. Una vez que los clientes se retiran, el camarero liberará el recurso (mesa) para que esté disponible de nuevo. Los usuarios ya están predefinidos en la base de datos, por lo que no se necesitan formularios de alta/baja/modificación.

####  🏗️ Estructura de la Aplicación

1. Login:
Nuestro login consiste en un formulario donde tiene que poner el usuario y contraseña. Aquí en la web hará validaciones por JavaScript y por PHP, donde nos aseguramos que antes de establecer conexión con el servidor, esté validado que se envíe algún campo y que este campo sea correcto. En el caso que todo esté correcto, saltaremos a la siguiente página.

2. Página de reserva de mesas:
Esta página lo que nos muestra es el usuario del camarero el cúal se ha registrado y seguidamente nos muestra un mapa con las salas y las mesas que hay en el restaurante. Cuando hagamos click encima de una mesa, en esta tendremos la opcion de reservarla. Una vez reservada la imagen cambiará a OCUPADO y esto dejará un registro.

3. Historial de mesas:
Está pagina mostrará el histórico de las mesas, donde podremos filtrar de manera que queramos para observar, por ejemplo, si el número de la mesa que queremos está ocupado. Aparte de eso esto nos viene bien para saber que mesa tiene cada camarero y demás.


#### Integrantes del Equipo
- **👨‍💻Eric Alcazar: Impulsor**
- **👨‍💻Dylan Castles: Finalizador**
- **👨‍💻David Hompanera: Cohesionador**
- **👨‍💻Manav Sharma: Coordinador**