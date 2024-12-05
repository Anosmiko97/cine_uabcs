<?php 
require_once "/xampp/htdocs/src/views/public/admin/layouts/header.php";
?>

<main>
<div class="container-fluid d-flex justify-content-end mt-4">
<button id="btnRegister" type="button" class="btn blue-btn me-4">Registrar asistencias marcadas</button>
    <button id="btnAttendance" type="button" class="btn blue-btn"
        data-bs-toggle="modal" data-bs-target="#attendanceModal">Agregar asistencia +</button>
</div>
    <div class="container shadow rounded bg-white mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Numero de control</th>
                    <th scope="col">Hora de entrada</th>
                    <th scope="col">Hora de salida</th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr>
                    <td>Larry the Bird</td>
                    <td>@twitter</td>
                    <td>@fat</td>
                </tr>
            </tbody>
        </table>
    </div>

</main>
<script>
   document.addEventListener('DOMContentLoaded', () => {
    const btnRegister = document.querySelector('#btnRegister');
    const btnAddAttendance = document.querySelector('#btnAttendance');
    const tbody = document.querySelector('.tbody');
    const addAttendance = document.querySelector('#addAttendance');
    let attendances = [];

    function sendData(attendances) {
        // Crear un formulario dinámico
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/registrar_asistencias/post'; // Cambia esta ruta por la que necesitas en tu backend

        // Iterar sobre las asistencias y añadirlas como campos ocultos
        attendances.forEach((attendance, index) => {
            Object.keys(attendance).forEach(key => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `attendances[${index}][${key}]`;
                input.value = attendance[key];
                form.appendChild(input);
            });
        });

        // Añadir el formulario al DOM y enviarlo
        document.body.appendChild(form);
        form.submit();
    }

    function drawAttendance(num_control) {
        // Obtener la hora actual formateada
        const dataTime = new Date();
        const currentTime = dataTime.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        });

        // Crear elementos para la fila
        const tr = document.createElement('tr');
        const tdNumControl = document.createElement('td');
        const tdEntryTime = document.createElement('td');
        const tdDepartureTime = document.createElement('td');

        // Asignar contenido a las primeras celdas
        tdNumControl.textContent = num_control;
        tdEntryTime.textContent = currentTime;

        // Crear un input para la hora de salida
        const departureInput = document.createElement('input');
        departureInput.type = 'time';
        departureInput.className = 'departure_time';
        tdDepartureTime.appendChild(departureInput);

        // Añadir las celdas a la fila
        tr.appendChild(tdNumControl);
        tr.appendChild(tdEntryTime);
        tr.appendChild(tdDepartureTime);
        tbody.appendChild(tr);

        // Añadir el objeto a la lista de asistencias
        attendances.push({
            num_control: num_control,
            entry_time: currentTime,
            departure_time: null // Será llenado más tarde
        });

        // Sincronizar entrada de hora de salida con el objeto
        departureInput.addEventListener('change', (e) => {
            const index = Array.from(tbody.children).indexOf(tr);
            if (index !== -1) {
                attendances[index].departure_time = e.target.value;
            }
        });
    }

    // Confirmación para registrar asistencias
    btnRegister.addEventListener('click', () => {
        if (confirm('¿Está seguro de registrar las asistencias? Las asistencias que no tengan una hora de salida no se guardarán.')) {
            const validAttendances = attendances.filter(a => a.departure_time !== null);
            sendData(validAttendances);
        }
    });

    // Agregar asistencia
    addAttendance.addEventListener('click', () => {
        const num_control = document.querySelector('#num_control');
        if (num_control.value.trim() === '') {
            alert('Por favor, ingrese un número de control válido.');
            return;
        }
        drawAttendance(num_control.value);
        num_control.value = ''; // Limpiar el campo de entrada después de agregar
    });
});

</script>

<!-- Modal para agregar asistencia -->
<div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-2">
            <div class="modal-body pt-2">
                <div class="container-fluid d-flex justify-content-end">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="mt-2">
                    <!-- Número de Control -->
                    <div class="mb-3">
                        <label class="form-label">Número de Control</label>
                        <input id="num_control" type="text" class="form-control" name="num_control" required>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="btn" id="addAttendance" class="btn blue-btn">AGREGAR ASISTENCIA</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>    
