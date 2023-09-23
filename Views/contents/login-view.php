<div class="login-container">
    <div class="login-content">
        <p class="text-center">
            <i class="fas fa-user-circle fa-5x"></i>
        </p>
        <p class="text-center">
            Inicia sesión con tu cuenta
        </p>
        <form action="" method="POST" autocomplete="off" >
            <div class="form-group">
                <label for="UserName" class="bmd-label-floating"><i class="fas fa-user-secret"></i> &nbsp; Usuario</label>
                <input type="text" class="form-control" id="UserName" name="usuario_log" pattern="[a-zA-Z0-9]{1,35}" maxlength="35" required="" >
            </div>
            <div class="form-group">
                <label for="UserPassword" class="bmd-label-floating"><i class="fas fa-key"></i> &nbsp; Contraseña</label>
                <input type="password" class="form-control" id="UserPassword" name="clave_log" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="" >
            </div>
            <button type="submit" class="btn-login text-center">LOG IN</button>
        </form>
    </div>
</div>

<?php
    //Si viene definido las variables globales POST se podrá iniciar sesión
    if (isset($_POST['usuario_log']) && isset($_POST['clave_log'])) {
        require_once "./Controllers/loginController.php";

        $ins_login = new loginController();

        echo $ins_login->iniciar_sesion_controlador();
    }
 ?>