<header>
    <a href="<?=$_ENV['BASE_URL']?>">
        <h1>P&Aacute;GINA DE TALLERES</h1>
    </a>

    <fieldset style='width:max-content; text-align:center'>
        <legend><strong>Para administrar: </strong></legend>
        admin@gmail.com <br> admin
    </fieldset>

    <nav>
        <ul>
            <?php if (!isset($_SESSION['usuario'])):?>
                <li><a href="<?=$_ENV['BASE_URL']?>usuario/login">Login</a></li>
                <li><a href="<?=$_ENV['BASE_URL']?>usuario/register">Registrarse</a></li>

            <?php else: ?>
                <li><a href="<?=$_ENV['BASE_URL']?>usuario/cerrar">Cerrar sesión</a></li>

            <?php endif;?>
        </ul>
    </nav>

</header>
