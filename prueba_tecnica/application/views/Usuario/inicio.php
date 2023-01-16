<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container'>
            <div class='card'>
                <div class='card-header'>
                        <h1>¡Bienvenido!</h1>
                </div>
                <div class='card-body'>
                    <p>Nombre: <?php echo ($_SESSION['login']['nombre']); ?></p>
                    <p>Perfil: <?php echo ($_SESSION['login']['rol']); ?></p>
                    <p>Correo: <?php echo ($_SESSION['login']['usuario']); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>