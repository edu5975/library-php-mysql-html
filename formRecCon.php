<?php
    include "head.php";
?>
    <form style="padding: 5% 10%" method="post" action="recuperar.php">
        <fieldset>
            <legend>Recuperar contraseña</legend>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input name='email' type="text" class="form-control" aria-describedby="Username" placeholder="Correo electronico">
            </div>
            <button type="submit" class="btn btn-primary">Recuperar</button>
        </fieldset>
    </form>
</body>

</html>