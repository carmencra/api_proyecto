<h2>Registro de usuario</h2>

<?php
//devolvemos los resultados de la operación
    if(isset($_SESSION['registro'])) {
        $resul= $_SESSION['registro'];

        //si son correctos, en verde
        $texto= "<fieldset style='width:max-content'>";
        if ($resul->status === 'OK') {
            $texto .= "Estado de la operación: ";
            $texto .= "<span style='color:green'>".$resul->status."</span>";

            $texto .= "<br>Resultado: ";
            $texto .= "<span style='color:green'>".$resul->message."</span>";
        }
        //si son incorrectos, en rojo
        else {
            $texto .= "Estado de la operación: ";
            $texto .= "<span style='color:red'>".$resul->status."</span>";

            $texto .= "<br>Resultado: ";
            $texto .= "<span style='color:red'>".$resul->message."</span>";
        }
        $texto .= "</fieldset>";

        echo $texto . "<br>";

        //borramos la sesión        
        $_SESSION['registro']= null;
        unset($_SESSION['registro']);
    } 
?>


<form action="<?=$_ENV['BASE_URL']?>usuario/register" method="POST">
    <label for="email">Email: </label>
    <input type="email" name="data[email]" value="<?php if (isset($_POST['data']['email']))echo $_POST['data']['email'];?>" style="width:300px">

    <br><br>

    <label for="password">Contraseña: </label>
    <input type="password" name="data[password]">

    <br><br>

    <input type="submit" value="Registrarse">
</form>
