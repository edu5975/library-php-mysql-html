<?php
    include "head.php";
?>

    <form style="padding: 5% 10%" method="post" action="registro.php">
        <fieldset>
            <legend>Registro</legend>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input name = 'email' type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingrese el correo">
                </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Nombre</label>
                <input name='nombre' type="text" class="form-control" aria-describedby="Username" placeholder="Nombre">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Apellido</label>
                <input name='apellidos' type="text" class="form-control" aria-describedby="Username" placeholder="Apellido">
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </fieldset>
    </form>
</body>

</html>