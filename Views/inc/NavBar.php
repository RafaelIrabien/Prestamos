<nav class="full-box navbar-info">
    <a href="#" class="float-left show-nav-lateral">
        <i class="fas fa-exchange-alt"></i>
    </a>
    
    <!-- Utilizamos la variable del loginController ubicado en plantilla.php 
         Utilizamos la función encryption de mainModel.php -->
    <a href="<?php echo SERVER_URL."user-update/".$lc->encryption($_SESSION['id_spm'])."/"; ?>">
        <i class="fas fa-user-cog"></i>
    </a>
    <a href="#" class="btn-exit-system">
        <i class="fas fa-power-off"></i>
    </a>
</nav>
