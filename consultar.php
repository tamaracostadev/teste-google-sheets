<?php
ini_set('error_reporting', E_ERROR);
require __DIR__ . '/autentica.php';

//consultar na planilha antiga - Tudo certo - retornando ok
$consulta = new Autentica;
$auth = $consulta->auth();
$itensAnt = $consulta->lookOld($_POST['consulta'], $auth, $_POST['num']);
if ($itensAnt == 0) {
    $retorno = false;
} else {
    $retorno = true;
}

//Consultar na aba atendimentos da plan nova

$itensNova = $consulta->lookAll($_POST['consulta'], $auth, $_POST['num']);
if ($itensNova == 0) {
    $ret = false;
} else {
    $ret = true;
}
unset($_POST);
