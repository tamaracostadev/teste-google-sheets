<?php
require __DIR__ . '/autentica.php';

/* Regras a aplicar
- Se não for precisar colocar a reclamação na planilha, simplesmente insere a reclamação na aba atendimento
Caso contrário
Faz a busca por pedido e CPF na planilha antiga e na nova
Se encontrar retorno, abre modal com o retorno e pergunta se é pra inserir mesmo assim
Se não encontrar, insere reclamação
*/



//Insere reclamação na planilha nova e na aba atendimento

$reclama = new Autentica;
$auth = $reclama->auth();


if ($_POST['check'] == 1) {
  $reclama->getPostRec($_SESSION['login'], $_SESSION['origem'], $_POST['ticket'], $_POST['pedido'], $_POST['cpf'], $_POST['nome'], $_POST['obs'], $_POST['Reclama'], $_POST['area']);
  $reclama->setSession();
  $_SESSION['insere'] = $_POST['acao'];
  if ($_POST['area'] != 'Mkt' && $_SESSION['insere'] != 1) {
    $itensAnt = $reclama->lookOld('pedido', $auth, $_POST['pedido']);
    if ($itensAnt == 0) {
      $itensAnt = $reclama->lookOld('cpf', $auth, $_POST['cpf']);
      if ($itensAnt == 0) {
        $retorno = false;
      } else {
        $retorno = true;
      }
    } else {
      $retorno = true;
    }

    //Consultar na aba atendimentos da plan nova

    $itensNova = $reclama->lookAll('pedido', $auth, $_POST['pedido']);
    if ($itensNova == 0) {
      $itensNova = $reclama->lookAll('cpf', $auth, $_POST['cpf']);
      if ($itensNova == 0) {
        $ret = false;
      } else {
        $ret = true;
      }
    } else {
      $ret = true;
    }
  }
  if ((!$retorno && !$ret) ||  $_POST['area'] == 'Mkt' || $_SESSION['insere'] == 1) {
    $insert = $reclama->insertProblem(0, $auth, $_SESSION['insere']);
  }
} elseif ($_POST['check'] == 3) {
  $reclama->getSession();
  $insert = $reclama->insertProblem(0, $auth, $_SESSION['insere']);
  $reclama->unsetSession();
  unset($_SESSION['insere']);
}
