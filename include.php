<?php
include"bd.php";
//RECEPÇÃO DE DADOS
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
$v_registro = date('Y-m-d H:i');
//IDADE
$v_dt1 = date_create($v_datanasc);
$v_datadehoje = date_create();
$v_resultado = date_diff($v_dt1, $v_datadehoje);
$v_idade = date_interval_format($v_resultado, '%Y');
//
//
//MOVE O ARQUIVO PRA UMA PASTA
if(move_uploaded_file($v_nomearquivotemp,$v_diretorio.'/'.$v_nomearquivo)){
//ENVIA O NOME DO ARQUIVO PARA O BD
    $v_envia = "INSERT INTO clientes ";
    $v_envia .="(Foto,Email,Nascimento,Bairro,Telefone,Descricao,Rua,Nome,Idade,Registro) ";
    $v_envia .="VALUES ";
    $v_envia .="('$v_nomearquivo','$v_email','$v_datanasc','$v_bairro','$v_telefone','$v_descricao','$v_rua','$v_nome','$v_idade','$v_registro') ";
    if($v_enviaquery = odbc_exec($connect,$v_envia)){
        header("location:index.php");
    }

 //
}

}
//
?>


<!Doctype HTML>
<html lang="pt-br">
<head>
<link rel="stylesheet" href="style.css">
        <title>Inclusão de Cliente</title>
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
<br>
<h1 align="center">Inserir Dados do Cliente</h1>
<div class="c_dadosescritos">

<form action="" method="POST" enctype="multipart/form-data">
 <!--//-->
<label for="i_Nome">Nome:</label>
<br>
<input type="name" id="i_Nome" name="f_nome">
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
<label for="i_Foto" style="cursor:pointer;" ><img id="output" width="250px" height="250px" ></label>
</div>
<br>
<!--//-->
<label for="i_Email">Email:</label>
<br>
<input type="name" id="i_Email" name="f_email">
<br>
<!--//-->
<label for="i_Telefone">Telefone:</label>
<br>
<input type="name" id="i_Telefone" name="f_telefone">
<br>
<!--//-->
<input type="file" id="i_Foto" style="display:none;" accept="image/*" onchange="loadFile(event)" name="f_foto">
<!--//-->
<label for="i_Nome">Bairro:</label>
<br>
<input type="name" id="i_Bairro" name="f_bairro">
<br>
<!--//-->
<label for="i_Rua">Rua:</label>
<br>
<input type="name" id="i_Rua" name="f_rua">
<br>
<!--//-->
<label for="i_Nome">Nascimento:</label>
<br>
<input type="date" id="i_Nome" name="f_nascimento">
<br>
<!--//-->
<label for="i_Desc">Descrição:</label>
<br>
<textarea name="f_descricao" id="i_Desc" cols="71" rows="20"></textarea>

<br>
<br>
<a href="index.php" id="i_cancelar" >Cancelar</a>
<button type="submit" id="i_enviar" name="f_enviar" >Cadastrar</button>
<br>
<br>
</form>
</div>
</body>



</html>