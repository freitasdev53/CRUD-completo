<?php
include"bd.php";
$v_id = $_GET["id"];
if(isset($_POST["f_enviar"])){
//IMAGENS
$v_nomearquivo = $_FILES["f_foto"]["name"];
$v_nomearquivotemp = $_FILES["f_foto"]["tmp_name"];
$v_diretorio = "img";
//
//DADOS ESCRITOS
$v_nome = $_POST["f_nome"];
$v_email = $_POST["f_email"];
$v_datanasc = $_POST["f_nascimento"];
$v_bairro = $_POST["f_bairro"];
$v_telefone = $_POST["f_telefone"];
$v_descricao = $_POST["f_descricao"];
$v_rua = $_POST["f_rua"];

//IDADE
$v_dt1 = date_create($v_datanasc);
$v_datadehoje = date_create();
$v_resultado = date_diff($v_dt1, $v_datadehoje);
$v_idade = date_interval_format($v_resultado, '%Y');
//
//
//MOVE O ARQUIVO PRA UMA PASTA
if(!empty($v_nomearquivo) && !empty($v_nomearquivotemp)){
if(move_uploaded_file($v_nomearquivotemp,$v_diretorio.'/'.$v_nomearquivo)){
//ENVIA O NOME DO ARQUIVO PARA O BD
    $v_envia = "UPDATE clientes SET Nome = '$v_nome', Email = '$v_email', Nascimento = '$v_datanasc', Bairro = '$v_bairro', Telefone = '$v_telefone',
    Descricao = '$v_descricao', Rua = '$v_rua', Idade = '$v_idade', Foto = '$v_nomearquivo' WHERE Id='$v_id'
    ";
    if($v_enviaquery = odbc_exec($connect,$v_envia)){
        header("location:index.php");
    }
}
 //
}
else{
    //ENVIA O NOME DO ARQUIVO PARA O BD
    $v_envia = "UPDATE clientes SET Nome = '$v_nome', Email = '$v_email', Nascimento = '$v_datanasc', Bairro = '$v_bairro', Telefone = '$v_telefone',
    Descricao = '$v_descricao', Rua = '$v_rua', Idade = '$v_idade' WHERE Id='$v_id'
    ";
    if($v_enviaquery = odbc_exec($connect,$v_envia)){
        header("location:index.php");
    }
}
}
?>
<!Doctype HTML>
<html lang="pt-br">
    <head>
        <title>CRUD</title>
<link rel="stylesheet" href="style.css">
        <style>

*{
    margin:0;
    font-family: "Helvetica Neue",Helvetica,Arial;
}

    #i_anexafoto{
        width:250px;
        height:250px;
        border:solid;
        padding:1%;
    }
.c_dadosescritos{
    display:flex;
    justify-content:center;
}
.c_dadosescritos input{
    padding:5px;
    width:500px;
    border:solid white 5px;
}

.c_dadosescritos textarea{
    padding:5px;
    width:500px;
    border:solid white 5px;
}

#i_enviar{
    float:right;
     background-color:rgb(46, 175, 235); 
     border:solid rgb(46, 175, 235); 
     color:white; 
     border-radius:10px; 
     cursor:pointer
}

#i_cancelar{
    float:left;
     background-color:red;
     border:solid red; 
     color:white; 
     border-radius:10px; 
     cursor:pointer;
     text-decoration:none;
     font-size:14px;
}

</style>

    </head>
    <body>

    <?php
    $v_id = $_GET['id'];
    $v_exibe = "SELECT * FROM clientes WHERE id='$v_id'";
    $v_exibequery = odbc_exec($connect,$v_exibe);
    while(odbc_fetch_row($v_exibequery)){

    ?>

<br>
<h1 align="center">Inserir Dados do Cliente</h1>
<div class="c_dadosescritos">

<form action="" method="POST" enctype="multipart/form-data">
 <!--//-->
<label for="i_Nome">Nome:</label>
<br>
<input type="name" id="i_Nome" name="f_nome" value="<?php echo odbc_result($v_exibequery,"Nome"); ?>">
<br>
<br>
<!--//-->
<h3 align="center">Anexar Foto:</h3>
<script>
      var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>
<div style="display:flex; justify-content:center;">
<label for="i_Foto" style="cursor:pointer;" ><img id="output" width="250px" height="250px" src="img/<?php echo odbc_result($v_exibequery,"Foto"); ?>" ></label>
</div>
<br>
<!--//-->
<label for="i_Email">Email:</label>
<br>
<input type="name" id="i_Email" name="f_email" value="<?php echo odbc_result($v_exibequery,"Email"); ?>">
<br>
<!--//-->
<label for="i_Telefone">Telefone:</label>
<br>
<input type="name" id="i_Telefone" name="f_telefone" value="<?php echo odbc_result($v_exibequery,"Telefone"); ?>">
<br>
<!--//-->
<input type="file" id="i_Foto" style="display:none;" accept="image/*" onchange="loadFile(event)" name="f_foto">
<!--//-->
<label for="i_Nome">Bairro:</label>
<br>
<input type="name" id="i_Bairro" name="f_bairro" value="<?php echo odbc_result($v_exibequery,"Bairro"); ?>">
<br>
<!--//-->
<label for="i_Rua">Rua:</label>
<br>
<input type="name" id="i_Rua" name="f_rua" value="<?php echo odbc_result($v_exibequery,"Rua"); ?>">
<br>
<!--//-->
<label for="i_Nome">Nascimento:</label>
<br>
<input type="date" id="i_Nome" name="f_nascimento" value="<?php echo odbc_result($v_exibequery,"Nascimento"); ?>">
<br>
<!--//-->
<label for="i_Desc">Descrição:</label>
<br>
<textarea name="f_descricao" id="i_Desc" cols="71" rows="20"><?php echo odbc_result($v_exibequery,"Descricao"); ?></textarea>

<br>
<br>
<a href="index.php" id="i_cancelar" >Cancelar</a>
<button type="submit" id="i_enviar" name="f_enviar" >Cadastrar</button>
<br>
<br>
</form>

<?php
    }
?>

</div>
</body>
</html>