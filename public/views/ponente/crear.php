<h2>Crear ponente</h2>

<?php
//devolvemos los resultados de la operación
    if(isset($_SESSION['crea_ponente'])) {
        $resul= $_SESSION['crea_ponente'];

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
        $_SESSION['crea_ponente']= null;
        unset($_SESSION['crea_ponente']);
    } 

?>


<form action="<?=$_ENV['BASE_URL']?>ponente/crear" method="POST" enctype="multipart/form-data">
    <label for="nombre">Nombre: </label>
    <input type="text" name="data[nombre]" value="<?php if (isset($_POST['data']['nombre']))echo $_POST['data']['nombre'];?>">

    <br><br>
    
    <label for="apellidos">Apellidos: </label>
    <input type="text" name="data[apellidos]" value="<?php if (isset($_POST['data']['apellidos']))echo $_POST['data']['apellidos'];?>">

    <br><br>
    
    <label for="imagen">Imagen: </label>
    <input type="file" name="imagen" accept="image/*">

    <br><br>
    
    <label for="tags">Tags: </label><br>
    <textarea cols="60" rows="2" name="data[tags]"><?php if (isset($_POST['data']['tags']))echo $_POST['data']['tags'];?></textarea>

    
    <br><br>
    
    <label for="redes">Redes: </label><br>
    <textarea cols="60" rows="2" name="data[redes]"><?php if (isset($_POST['data']['redes']))echo $_POST['data']['redes'];?></textarea>

    <br><br>   

    <input type="submit" value="Crear ponente">
</form>
