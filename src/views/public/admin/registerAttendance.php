<?php 
require_once "/xampp/htdocs/src/views/public/admin/layouts/header.php";
?>

<main>
<div class="container-fluid d-flex justify-content-end mt-4">
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
        //const btnAddAttendance = document.querySelector('#btnAttendance');
        const tbody = document.querySelector('.tbody');
        const addAttendance = document.querySelector('#addAttendance');

        addAttendance.addEventListener('click', () => {
            const num_control = document.querySelector('#num_control');
            console.log(num_control.value);
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
