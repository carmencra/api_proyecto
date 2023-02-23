<h2>Modificar ponente</h2>

<?php
//devolvemos los resultados de la operación
    if(isset($_SESSION['modifica_ponente'])) {
        $resul= $_SESSION['modifica_ponente'];

        //si son correctos, en verde
        if ($resul->status === 'OK') {
            //si se modifica, lo mostrará en listar
        }
        //si son incorrectos, en rojo
        else {
            $texto= "<fieldset style='width:max-content'>";
            $texto .= "Estado de la operación: ";
            $texto .= "<span style='color:red'>".$resul->status."</span>";

            $texto .= "<br>Resultado: ";
            $texto .= "<span style='color:red'>".$resul->message."</span>";

            $texto .= "</fieldset>";

            echo $texto . "<br>";
            
            //borramos la sesión        
            $_SESSION['modifica_ponente']= null;
            unset($_SESSION['modifica_ponente']);
        }        
    } 

?>


<form action="<?=$_ENV['BASE_URL']?>ponente/modificar" method="POST" enctype="multipart/form-data">

<label for="nombre">Nombre: </label>
    <input type="text" name="data[nombre]" value="<?php if (isset($ponente))echo $ponente['nombre'];?>">

    <br><br>
    
    <label for="apellidos">Apellidos: </label>
    <input type="text" name="data[apellidos]" value="<?php if (isset($ponente))echo $ponente['apellidos'];?>">

    <br><br>
    
    <label for="imagen">Imagen: </label>
    <input type="file" name="imagen" accept="image/*">

    <br><br>
    
    <label for="tags">Tags: </label><br>
    <textarea cols="60" rows="2" name="data[tags]"><?php if (isset($ponente))echo $ponente['tags'];?></textarea>

    
    <br><br>
    
    <label for="redes">Redes: </label><br>
    <textarea cols="60" rows="2" name="data[redes]"><?php if (isset($ponente))echo $ponente['redes'];?></textarea>

    <br><br>   

    <input type="submit" value="Modificar ponente">
</form>
