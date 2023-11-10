<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fab fa-dashcube fa-fw"></i> &nbsp; DASHBOARD
    </h3>
    <p class="text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
    </p>
</div>

<!-- Content -->
<div class="full-box tile-container">
    <?php
        require_once "./Controllers/clienteController.php";
        $ins_cliente = new clienteController();
        $total_clientes = $ins_cliente->datos_cliente_controlador("Conteo",0);
     ?>
    <a href="<?php echo SERVER_URL; ?>client-new/" class="tile">
        <div class="tile-tittle">Clientes</div>
        <div class="tile-icon">
            <i class="fas fa-users fa-fw"></i>
            <!-- Se cuentan los clientes registrados -->
            <p><?php echo $total_clientes->rowCount(); ?> Registrados</p>
        </div>
    </a>
    
    <a href="<?php echo SERVER_URL; ?>item-list/" class="tile">
        <div class="tile-tittle">Items</div>
        <div class="tile-icon">
            <i class="fas fa-pallet fa-fw"></i>
            <p>9 Registrados</p>
        </div>
    </a>

    <a href="<?php echo SERVER_URL; ?>reservation-reservation/" class="tile">
        <div class="tile-tittle">Reservaciones</div>
        <div class="tile-icon">
            <i class="far fa-calendar-alt fa-fw"></i>
            <p>30 Registradas</p>
        </div>
    </a>

    <a href="<?php echo SERVER_URL; ?>reservation-pending/" class="tile">
        <div class="tile-tittle">Prestamos</div>
        <div class="tile-icon">
            <i class="fas fa-hand-holding-usd fa-fw"></i>
            <p>200 Registrados</p>
        </div>
    </a>

    <a href="<?php echo SERVER_URL; ?>reservation-list/" class="tile">
        <div class="tile-tittle">Finalizados</div>
        <div class="tile-icon">
            <i class="fas fa-clipboard-list fa-fw"></i>
            <p>700 Registrados</p>
        </div>
    </a>

    <?php
        //Solo se le mostrará a los usuarios con privilegio nivel 1
        if ($_SESSION['privilegio_spm']==1) {
        
        require_once "./Controllers/usuarioController.php";
        $ins_usuario = new usuarioController();
        $total_usuarios = $ins_usuario->datos_usuario_controlador("Conteo",0);
    ?>
    <a href="<?php echo SERVER_URL; ?>user-list/" class="tile">
        <div class="tile-tittle">Usuarios</div>
        <div class="tile-icon">
            <i class="fas fa-user-secret fa-fw"></i>
            <!-- Se cuentan los usuarios registrados -->
            <p><?php echo $total_usuarios->rowCount(); ?> Registrados</p>
        </div>
    </a>
    <?php } ?>

    
    <a href="<?php echo SERVER_URL; ?>company/" class="tile">
        <div class="tile-tittle">Empresa</div>
        <div class="tile-icon">
            <i class="fas fa-store-alt fa-fw"></i>
            <p>1 Registrada</p>
        </div>
    </a>
</div>
