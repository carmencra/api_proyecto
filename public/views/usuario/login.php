
<h2>Login de usuario</h2>

<?php
//devolvemos los resultados de la operación
    if(isset($_SESSION['login'])) {
        $resul= $_SESSION['login'];

        if ($resul->status === 'OK') {
            //si son correctos, lo muestra en el inicio
        }
        //si son incorrectos, los muestra en rojo
        else {
            $texto= "<fieldset style='width:max-content'>";

            $texto .= "Estado de la operación: ";
            $texto .= "<span style='color:red'>".$resul->status."</span>";

            $texto .= "<br>Resultado: ";
            $texto .= "<span style='color:red'>".$resul->message."</span>";
            
            $texto .= "</fieldset>";
    
            echo $texto . "<br>";
    
            //borramos la sesión        
            $_SESSION['login']= null;
            unset($_SESSION['login']);
        }
    } 
?>

<form action="<?=$_ENV['BASE_URL']?>usuario/login" method="POST">

    <label for="email">Email: </label>
    <input type="email" name="data[email]" value="<?php if (isset($_POST['data']['email']))echo $_POST['data']['email'];?>" style="width:300px">

    <br><br>

    <label for="password">Contraseña: </label>
    <input type="password" name="data[password]">

    <br><br>

    <input type="submit" value="Login">
</form>
