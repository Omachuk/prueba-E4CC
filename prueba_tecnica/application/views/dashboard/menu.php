<div class="dashboard-nav">
    <header>
        <a href="#" class="brand-logo">
        	<i class="fas fa-university"></i> <span>E4CC</span>
        </a>
    </header>

    <nav class="dashboard-nav-list">
        <?php if($_SESSION['login']['rol_tipo'] == 1){ ?>
        <a href="<?= base_url();?>index.php/Inicio/home" class="dashboard-nav-item <?php if(!empty($home)){echo $home;} ?>">
        	<i class="fas fa-home"></i> Inicio 
        </a>
        <?php } ?>
        <?php if($_SESSION['login']['rol_tipo'] == 1){ ?>
        <a href="<?= base_url();?>index.php/Inicio/get_usuarios" class="dashboard-nav-item <?php if(!empty($user)){echo $user;} ?>">
        	<i class="fa fa-users"></i> Usuarios
        </a>
        <?php } ?>
        <?php if($_SESSION['login']['rol_tipo'] == 1){ ?>
        <a href="<?= base_url();?>index.php/Clases" class="dashboard-nav-item <?php if(!empty($clase_menu)){echo $clase_menu;} ?>">
        	<i class="fas fa-language"></i> Clases 
        </a>
        <?php } ?>
        <?php if($_SESSION['login']['rol_tipo'] == 2){ ?>
        <a href="<?= base_url();?>index.php/Inicio/home_usuario" class="dashboard-nav-item <?php if(!empty($home)){echo $home;} ?>">
            <i class="fas fa-home"></i> Inicio 
        </a>
        <?php } ?>
        <div class="nav-item-divider"></div>
        <a class="dashboard-nav-item" href="<?= base_url();?>index.php/Inicio/logout">
          <i class="fas fa-sign-out-alt"></i> Cerrar sesion 
        </a>
    </nav>
</div>
    