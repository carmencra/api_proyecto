<h1>Lista de ponentes</h1>

<?php
//devolvemos si el ponente se ha borrado ponente
    if(isset($_SESSION['borrar_ponente'])) {
        $resul= $_SESSION['borrar_ponente'];

        //para la ruta de la imagen
        $_SESSION['borrar']= true;

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
        $_SESSION['borrar_ponente']= null;
        unset($_SESSION['borrar_ponente']);
    } 
    
    //devolvemos si el ponente se ha modificado
    if(isset($_SESSION['modifica_ponente'])) {
        $resul= $_SESSION['modifica_ponente'];
        
        //si son correctos, en verde
        if ($resul->status === 'OK') {
            $texto= "<fieldset style='width:max-content'>";
            $texto .= "Estado de la operación: ";
            $texto .= "<span style='color:green'>".$resul->status."</span>";

            $texto .= "<br>Resultado: ";
            $texto .= "<span style='color:green'>".$resul->message."</span>";
        
            //borramos la sesión        
            $_SESSION['modifica_ponente']= null;
            unset($_SESSION['modifica_ponente']);
            
            $_SESSION['ponente']= null;
            unset($_SESSION['ponente']);
        }

        $texto .= "</fieldset>";

        echo $texto . "<br>";
    }

    //devolvemos si el usuario ha sido confirmado
    if(isset($_SESSION['confirmar_usuario'])) {
        $resul= $_SESSION['confirmar_usuario'];

        //para la ruta de la imagen
        $_SESSION['borrar']= true;

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
        $_SESSION['confirmar_usuario']= null;
        unset($_SESSION['confirmar_usuario']);
    } 
?>

<?php if(isset($_SESSION['admin'])):?>
    <li><a href="<?=$_ENV['BASE_URL']?>ponente/crear">Crear ponente</a></li> <br>
<?php endif;?>

<?php if (!empty($ponentes)):?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>APELLIDOS</th>
            <th>IMAGEN</th>
            <th>TAGS</th>
            <th>REDES</th>
        </tr>

        <?php 
        foreach ($ponentes as $ponen): ?>

            <tr>
                <td align='center'> <?= $ponen['id']; ?> </td>
                <td align='center'> <?= $ponen['nombre']; ?> </td>
                <td align='center'> <?= $ponen['apellidos']; ?> </td>
                <td align='center'> 
                    <img src="images/<?= $ponen['imagen']; ?> " width="175px"> 
                </td>
                <td align='center'> <?= $ponen['tags']; ?> </td>
                <td align='center'> <?= $ponen['redes']; ?> </td>


                <?php if(isset($_SESSION['admin'])):?>
                    <td>
                        <form action="<?=$_ENV['BASE_URL'].'ponente/modificar/'.$ponen['id']?>" method="POST">
                            <input type="submit" value="Modificar ponente">
                        </form>
                    </td>

                    <td>
                        <form action="<?=$_ENV['BASE_URL'].'ponente/delete/'.$ponen['id']?>" method="POST">
                            <input type="submit" value="Borrar ponente">
                        </form>
                    </td>
                <?php endif;?>
            </tr>
            
        <?php endforeach; ?>

        
    </table>

<?php else: ?>
    <strong>No hay ponentes disponibles</strong>
<?php endif; ?>
