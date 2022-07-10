<?php
date_default_timezone_set('America/Sao_Paulo');
$server ="DESKTOP-2CM82J2\SQLEXPRESS";
$user = "sa";
$pw ="3841";
$database ="Crud";
$connect = odbc_connect("Driver={SQL Server Native Client 11.0};Server=$server;Database=$database;",$user,$pw);
session_start();
?>