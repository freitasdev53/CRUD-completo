<?php
include"bd.php";

if(isset($_GET["del"])){
    $v_clientedel = $_GET["del"];
    $v_del = "DELETE FROM Clientes WHERE id='$v_clientedel' ";
    if($v_delquery = odbc_exec($connect,$v_del)){
        header("location:index.php");
    }
}
////COLETA OS ELEMENTOS DO FILTRO VIA URL

if(!isset($_GET["f_tipo"]) && !isset($_GET["v_dt1"]) && !isset($_GET["v_dt2"]) && !isset($_GET["f_bairro"]) && !isset($_GET["f_faixa"]) && !isset($_GET["f_pesquisar"]) ){
    header("location:index.php?f_tipo=0&v_dt1=&v_dt2=&f_bairro=0&f_faixa=0&f_pesquisar=");
}

$v_tipo = $_GET["f_tipo"];
$v_dt1 = $_GET["v_dt1"];
$v_dt2 = $_GET["v_dt2"];
$v_bairro = $_GET["f_bairro"];
$v_faixa = $_GET["f_faixa"];
$v_pesquisar = $_GET["f_pesquisar"];


//ARRAY DAS CONSULTAS SQL DOS FILTROS
$v_filtra = [
    //INDIVIDUAL
    "SELECT * FROM Clientes",
    "SELECT * FROM Clientes WHERE Nascimento >= '$v_dt1' AND Nascimento <= '$v_dt2' ",
    "SELECT * FROM Clientes WHERE Registro >= '$v_dt1' AND Registro <= '$v_dt2' ",
    "SELECT * FROM Clientes WHERE Bairro LIKE '%$v_bairro%' ",
    "SELECT * FROM Clientes WHERE Idade >= 18",
    "SELECT * FROM Clientes WHERE Idade <= 18",
    "SELECT * FROM Clientes WHERE Nome LIKE '%$v_pesquisar%' ",
    //NASCIDOS/REGISTRADOS E BAIRRO
    "SELECT * FROM Clientes WHERE Nascimento >= '$v_dt1' AND Nascimento <= '$v_dt2' AND Bairro LIKE '%$v_bairro%' ",
    "SELECT * FROM Clientes WHERE Registro >= '$v_dt1' AND Registro <= '$v_dt2' AND Bairro LIKE '%$v_bairro%' ",
    //REGISTRADOS E FAIXA ETARIA
    "SELECT * FROM Clientes WHERE Registro >= '$v_dt1' AND Registro <= '$v_dt2' AND Idade >=18 ",
    "SELECT * FROM Clientes WHERE Registro >= '$v_dt1' AND Registro <= '$v_dt2' AND Idade <=18 ",
    //BAIRRO E FAIXA ETARIA
    "SELECT * FROM Clientes WHERE Idade >= 18 AND Bairro LIKE '%$v_bairro%' ",
    "SELECT * FROM Clientes WHERE Idade <= 18 AND Bairro LIKE '%$v_bairro%' ",
];
//CONDICIONAIS DOS FILTROS
//TODOS
if($v_tipo == 0 && empty($v_dt1) && empty($v_dt2) && $v_bairro == 0 && $v_faixa == 0 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[0];
}
//NASCIMENTO
if($v_tipo == 1 && !empty($v_dt1) && !empty($v_dt2) && $v_bairro == 0 && $v_faixa == 0 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[1];
}
//REGISTRO
if($v_tipo == 2 && !empty($v_dt1) && !empty($v_dt2) && $v_bairro == 0 && $v_faixa == 0 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[2];
}
//BAIRRO
if($v_tipo == 0 && empty($v_dt1) && empty($v_dt2) && $v_bairro != 0 && $v_faixa == 0 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[3];
}elseif($v_tipo == 0 && empty($v_dt1) && empty($v_dt2) && $v_bairro == 0 && $v_faixa == 0 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[0];
}
//IDADE (MAIOR)
if($v_tipo == 0 && empty($v_dt1) && empty($v_dt2) && $v_bairro == 0 && $v_faixa == 1 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[4];
}
//IDADE (MENOR)
if($v_tipo == 0 && empty($v_dt1) && empty($v_dt2) && $v_bairro == 0 && $v_faixa == 2 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[5];
}
//PESQUISA POR TEXTO
if($v_tipo == 0 && empty($v_dt1) && empty($v_dt2) && $v_bairro == 0 && $v_faixa == 0 && !empty($v_pesquisar)){
    $v_exibe = $v_filtra[6];
}
//NASCIDOS BAIRRO
if($v_tipo == 1 && !empty($v_dt1) && !empty($v_dt2) && $v_bairro != 0 && $v_faixa == 0 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[7];
}elseif($v_tipo == 1 && !empty($v_dt1) && !empty($v_dt2) && $v_bairro == 0 && $v_faixa == 0 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[1];
}
//REGISTRADOS BAIRRO
if($v_tipo == 2 && !empty($v_dt1) && !empty($v_dt2) && $v_bairro != 0 && $v_faixa == 0 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[8];
}elseif($v_tipo == 2 && !empty($v_dt1) && !empty($v_dt2) && $v_bairro == 0 && $v_faixa == 0 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[2];
}
//REGISTRADOS E IDADE (MAIOR)
if($v_tipo == 2 && !empty($v_dt1) && !empty($v_dt2) && $v_bairro == 0 && $v_faixa == 1 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[9];
}
//REGISTRADOS E IDADE (MENOR)
if($v_tipo == 2 && !empty($v_dt1) && !empty($v_dt2) && $v_bairro == 0 && $v_faixa == 2 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[10];
}
//BAIRRO E IDADE (MAIOR)
if($v_tipo == 0 && empty($v_dt1) && empty($v_dt2) && $v_bairro != 0 && $v_faixa == 1 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[11];
}elseif($v_tipo == 0 && empty($v_dt1) && empty($v_dt2) && $v_bairro == 0 && $v_faixa == 2 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[4];
}
//BAIRRO E IDADE (MENOR)
if($v_tipo == 0 && empty($v_dt1) && empty($v_dt2) && $v_bairro != 0 && $v_faixa == 2 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[12];
}elseif($v_tipo == 0 && empty($v_dt1) && empty($v_dt2) && $v_bairro == 0 && $v_faixa == 2 && empty($v_pesquisar)){
    $v_exibe = $v_filtra[5];
}
//
?>
<!Doctype HTML>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Home: CRUD</title>
    <style>
        #i_add{
    margin-right:2%;
    text-decoration:none;
    background-color:rgb(46, 175, 235);
    color:white;
    height:20px;
    padding:10px;
    border-radius:10px;
}

.c_tabela table{
    width:1000px;
    justify-content:center;
    text-align:center;
}
#i_pen{
    color:rgb(46, 175, 235);
}
#i_trash{
    color:red;
}
    </style>
</head>
<body>
<main class="c_crud">
<header class="c_filtros">
<!--FILTROS-->

<form action="" method="GET" class="c_filtro">
<label for="i_tipo">Data:</label>

<select name="f_tipo" id="i_tipo">
<option value="0">Todos</option>
<option value="1">Nascimento</option>
<option value="2">Registro</option>
</select>

<label for="i_dt1">De:</label>
<input type="date" name="v_dt1" id="i_dt1" value="<?php echo $v_dt1;?>">
<label for="i_dt2">Ate:</label>
<input type="date" name="v_dt2" id="i_dt2" value="<?php echo $v_dt2;?>">

<label for="i_bairro">Bairro:</label>
<select name="f_bairro" id="i_bairro" style="width:150px;">
<option value="0">Todos</option>
<?php
$v_selbairro = "SELECT Bairro FROM Clientes";
$v_selbairroquery = odbc_exec($connect,$v_selbairro);
while(odbc_fetch_row($v_selbairroquery)){
?>
<option value="<?php echo odbc_result($v_selbairroquery,"Bairro");?>"><?php echo odbc_result($v_selbairroquery,"Bairro");?></option>
<?php
}
?>
</select>

<label for="i_faixa">Faixa Etária:</label>
<select name="f_faixa" id="i_faixa">
<option value="0">Todos</option>
<option value="1">Maior</option>
<option value="2">Menor</option>
</select>
<input type="hidden" name="f_pesquisar">
<button type="submit"><i class="fas fa-filter"></i></button>
<a href="index.php">Todos</a>
</form>
<!--PESQUISA GERAL-->
<form action="" method="GET" class="c_geral">
    <input type="search" name="f_pesquisar">
    <button type="submit"><i class="fas fa-search"></i></button>
    <input type="hidden" name="f_tipo" value="0">
    <input type="hidden" name="v_dt1" >
    <input type="hidden" name="v_dt2" >
    <input type="hidden" name="f_bairro" value="0">
    <input type="hidden" name="f_faixa" value="0">
</form>
<!--//-->
</header>
<!--TABELA-->
<article class="c_tabela">
    <table border>
        <tr style="background:#2a2438; color:white;">
            <td>Nome</td>
            <td>Email</td>
            <td>Telefone</td>
            <td>Bairro</td>
            <td>Registro</td>
            <td>Nascimento</td>
            <td>Idade</td>
            <td>Opções</td>
        </tr>
        <?php
        
        $v_exibequery = odbc_exec($connect,$v_exibe);
        while(odbc_fetch_row($v_exibequery)){
        ?>
        <tr>
            <td><a href="dados.php?id=<?php echo odbc_result($v_exibequery,'Id');?>"><?php echo odbc_result($v_exibequery,"Nome"); ?></a></td>
            <td><?php echo odbc_result($v_exibequery,"Email"); ?></td>
            <td><?php echo odbc_result($v_exibequery,"Telefone"); ?></td>
            <td><?php echo odbc_result($v_exibequery,"Bairro"); ?></td>
            <td><?php echo date('m/d/Y',strtotime(odbc_result($v_exibequery,"Registro"))); ?></td>
            <td><?php echo date('d/m/Y',strtotime(odbc_result($v_exibequery,"Nascimento"))); ?></td>
            <td><?php echo odbc_result($v_exibequery,"Idade"); ?></td>
            <td><a href="edit.php?id=<?php echo odbc_result($v_exibequery,'Id');?>"><i class="fa-solid fa-pen-to-square" id="i_pen"></i></a>&nbsp;<a href="index.php?del=<?php echo odbc_result($v_exibequery,'Id');?>"><i class="fa-solid fa-trash" id="i_trash"></i></a></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <br>
    <a href="include.php" id="i_add">Adicionar</a>
</article>

<!--//-->

</main>
</body>
</html>