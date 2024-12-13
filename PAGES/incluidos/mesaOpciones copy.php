<div id="formOpcionesRecurso">
    <h1>Opciones mesa 3</h1>
    <strong>Sin reservar</strong>
    <br>
    <form action="../../php/process_mesa.php" method="post">
        <strong>Info:</strong>
        <p>Sala en la que esta: 5 (tipo sala privada)</p>
        <br>
        <p>Estado: libre</p>
        <br>
        <strong>Editar:</strong>
        <p>Sillas que se quieren incluir (input que solo deja numeros de la cantidad de sillas libres)</p>
        <input type="number" name="" id="" value="2">
        <br>
        <br>
        <p>Nombre del cliente que reserva (aunque sea el mismo cliente se hace un insert nuevo en la tabla personas y en la de ocupacion)</p>
        <input type="number" name="" id="">
        <br>
        <br>
        <p>Apellido del cliente que reserva:</p>
        <input type="number" name="" id="">
        <br>
        <br>
        <p>Input de los detalles de la ocupacion:</p>
        <input type="number" name="" id="">
        <br>
        <br>
        <p>Tipo:</p>
        <label>
            <input type="radio" name="option"> Ahora
        </label>
        <label>Tiempo:
        <select name="" id="">
            <option value="1">1 hora</option>
            <option value="2">2 horas</option>
            <option value="3">3 horas</option>
            <option value="4">4 horas</option>
        </select>
        </label>
        <br>
        <br>
        <label>
            <input type="radio" name="option"> Reserva
        </label>
        <label>Fecha inicio:
            <input type="datetime-local" name="" id="">
        </label>
        <label>Fecha final:
            <input type="datetime-local" name="" id="">
        </label>
        <br>
        <button>Ocupar</button>
    </form>
    <br>
    <br>
    <br>
    <br>
    <strong>Reservada</strong>
    <br>
    <form action="../../php/process_mesa.php" method="post">
        <strong>Info:</strong>
        <p>Sala en la que esta: 5 (tipo sala privada)</p>
        <br>
        <p>Estado: ocupado</p>
        <br>
        <p>Cantidad de sillas: 5</p>
        <br>
        <p>Nombre apellido cliente: Juan Lopez</p>
        <br>
        <p>Nombre usuario empleado: dylan_castles</p>
        <br>
        <p>Detalles de la ocupacion: cumpleaños de un chico, quiere pastel</p>
        <br>
        <p>Fecha inicio: 12/12/23 14:30</p>
        <br>
        <p>Fecha final: 12/12/23 16:30</p>
        <br>
        <button>Cancelar</button>
    </form>
</div>