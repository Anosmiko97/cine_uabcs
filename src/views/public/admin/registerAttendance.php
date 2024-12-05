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
            const tdCheckbox = document.createElement('td');

            // Asignar contenido a las primeras celdas
            tdNumControl.textContent = num_control;
            tdEntryTime.textContent = currentTime;

            // Crear un input para la hora de salida
            const departureInput = document.createElement('input');
            departureInput.type = 'time';
            departureInput.name = `departure_time_${num_control}`; 
            tdDepartureTime.appendChild(departureInput);

            // Crear el checkbox
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = `attendance_${num_control}`;
            checkbox.value = num_control;

            // Evento para detectar cambios en el estado del checkbox
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    console.log(`Checkbox marcado para el número de control: ${num_control}`);
                } else {
                    console.log(`Checkbox desmarcado para el número de control: ${num_control}`);
                }
            });

            // Añadir el checkbox a la celda
            tdCheckbox.appendChild(checkbox);

            // Añadir las celdas a la fila
            tr.appendChild(tdNumControl);
            tr.appendChild(tdEntryTime);
            tr.appendChild(tdDepartureTime);
            tr.appendChild(tdCheckbox);

            // Obtener el tbody y añadir la fila
            if (tbody) {
                tbody.appendChild(tr);
            } else {
                console.error('No se encontró el elemento tbody con ID "attendance_table_body".');
            }
        }

        const btnAddAttendance = document.querySelector('#btnAttendance');
        const tbody = document.querySelector('.tbody');
        const addAttendance = document.querySelector('#addAttendance');

        addAttendance.addEventListener('click', () => {
            const num_control = document.querySelector('#num_control');
            console.log(num_control.value);
            drawAttendance(num_control.value);
        });
    });   
</script>

<!-- Modal -->
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
