<?php
    include "head.php";
?>
    <form style="padding: 5% 10%" method="post" action="validar.php">
        <fieldset>
            <legend>Ingresar</legend>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input name='usr' type="text" class="form-control" aria-describedby="Username" placeholder="Correo electronico">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Contraseña</label>
                <input name='pwd' type="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña">
            </div>
            <button type="submit" class="btn btn-primary">Iniciar</button>
            
            <a  href="formRecCon.php">
            <button type="button" class="btn btn-primary" >
                Recuperar contraseña
            </button>  
             </a>
        </fieldset>
    </form>     
</body>

</html>