<?php


if(isset($_POST["envia"])){
    $database = date_create($_POST['dt']);
    $datadehoje = date_create();
    $resultado = date_diff($database, $datadehoje);
    echo date_interval_format($resultado, '%Y');

    
}



?>
<form action="" method="POST">
<input type="date" name="dt">
<input type="submit" name="envia">
</form>