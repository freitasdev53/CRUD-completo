<?php
include"bd.php";
?>
<!Doctype HTML>
<html lang="pt-br">
    <head>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <title>Exibição</title>
    <style>
*{
    margin:0;
    font-family: "Helvetica Neue",Helvetica,Arial;
    overflow-x:hidden;
}
        .c_exibefoto{
            float:left;
        }
        .c_exibicao{
            display:flex;
            flex-direction:row;
            width:100%;
            justify-content:center;
            background-color:#fcfefe;
            padding:1%;
        }
        .c_exibicao h1{
            margin-left: 2%;
        }
        .c_exibicao h2{
            margin-left: 2%;
        }
        .c_exibicao p{
            margin-left: 2%;
        }
        .c_exibicao div{
            width:100%;
        }
        .c_sobre{
            display:flex;
            flex-direction:column;
            align-items:center;
        }
        .c_exibicao a{
            margin-right:2%;
            text-decoration:none;
            background-color:rgb(46, 175, 235);
            color:black;
            height:20px;
            padding:10px;
            border-radius:10px;
        }

        .c_dados{
            display:flex;
            flex-direction:row;
            float:left;
            width:100%;
            margin-top:3%;
        }
        #i_title{
           margin-right:34.5%;
           position:absolute;
        }
    </style>
    </head>
<body>


<header class="c_exibicao">
<?php
    $v_id = $_GET['id'];
    $v_exibe = "SELECT * FROM clientes WHERE id='$v_id'";
    $v_exibequery = odbc_exec($connect,$v_exibe);
    while(odbc_fetch_row($v_exibequery)){

    ?>
    <img src="img/<?php echo odbc_result($v_exibequery,"Foto"); ?>" width="250px" height="250px" class="c_exibefoto">


<h1 id="i_title"><?php echo odbc_result($v_exibequery,"Nome"); ?></h1>

    

<div class="c_dados">

<br>

<div>

<h2>Bairro:</h2>
<p><?php echo odbc_result($v_exibequery,"Bairro"); ?></p>
<br>
<h2>Rua:</h2>
<p><?php echo odbc_result($v_exibequery,"Rua"); ?></p>
<br>
<h2>Idade:</h2>
<p><?php echo odbc_result($v_exibequery,"idade"); ?></p>
</div>

<div>
<h2>Email:</h2>
<p><?php echo odbc_result($v_exibequery,"Email"); ?></p>
<br>
<h2>Telefone:</h2>
<p><?php echo odbc_result($v_exibequery,"Telefone"); ?></p>
<br>
<h2>Nascimento:</h2>
<p><?php echo date('d/m/Y',strtotime(odbc_result($v_exibequery,"Nascimento"))); ?></p>
</div>

</div>
<a href="index.php">Home</a>
</header>
<article class="c_sobre">
    <h1>Sobre:</h1>
    <br>
<p>
<?php echo wordwrap(odbc_result($v_exibequery,"Descricao"),70,'<br>',TRUE); ?>
</p>
</article>
<?php
    }
?>
</body>
</html>