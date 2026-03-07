
<doctype html>
<html lang="es">

<body>
    <div>
        <h1>Registro de Usurario</h1>

        <form method="post" action="/register">
            
            @csrf 

            <label for="nombre_apellido">Nombre y apellido:</label>
            <input type="text" id="nombre_apellido" name="nombre_apellido" required>
            <br><br>
            <label for="identificacion">Identificación:</label>
            <input type="number" id="identificacion" name="identificacion" required maxlength="20">
            <br><br>
            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required maxlength="255">
            <br><br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required minlength="8">
            <br><br>
            <label for="password_confirmation">Confirmar contraseña:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8">
            <br><br>


            si el checkbox de administrador esta marcado se muestra label para rol y area, si no esta marcado se ocultan ambos label y sus respectivos input
            <label for="administrador">Administrador:</label>
            <input type="checkbox" id="administrador" name="administrador">

            <br><br>
            <div id="admin_fields" style="display: none;">
                <label for="rol">Rol:</label>
                <input type="text" id="rol" name="rol" maxlength="255"> 
                <br><br>
                <label for="area">Área:</label>
                <input type="text" id="area" name="area" maxlength="255">
            </div>


            si el checkbox de estudiante esta marcado se muestra label para facultad, nombre de carrera y semestre si no esta marcado se ocultan ambos label y sus respectivos input
            <label for="estudiante">Estudiante:</label>
            <input type="checkbox" id="estudiante" name="estudiante">
            <br><br>

            <div id="student_fields" style="display: none;">
                <label for="facultad">Facultad:</label>
                <input type="text" id="facultad" name="facultad" maxlength="255">
                <br><br>
                <label for="nombre_carrera">Nombre de carrera:</label>
                <input type="text" id="nombre_carrera" name="nombre_carrera" maxlength="255">
                <br><br>
                <label for="semestre">Semestre:</label>
                <input type="number" id="semestre" name="semestre">
            </div>

            <br><br>

            <button type="submit">Registrar</button>
        </form>
    </div>

    <script>
        document.getElementById('administrador').addEventListener('change', function() {
            var adminFields = document.getElementById('admin_fields');
            if (this.checked) {
                adminFields.style.display = 'block';
            } else {
                adminFields.style.display = 'none';
            }
        });

        document.getElementById('estudiante').addEventListener('change', function(){
            var studentFields = document.getElementById('student_fields');
            if (this.checked) {
                studentFields.style.display = 'block';
            } else {
                studentFields.style.display = 'none';
            }
        });
    </script>   




</body>


</html>     