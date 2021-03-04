<?php
require __DIR__ . '/autentica.php';


//Insere reclamação na planilha nova
$reclama = new Autentica;
$auth = $reclama->auth();
$reclama->getPostRec($_SESSION['login'], $_SESSION['origem'], $_POST['ticket'], $_POST['pedido'], $_POST['cpf'], $_POST['nome'], $_POST['obs'], $_POST['Reclama'], $_POST['area']);
if ($reclama->insertProblem(0, $auth) == 1) {
  echo 'enviado'; // Substituir por modal de sucesso
} else {
}

//teste


/* Regras a aplicar
- Consultar na planilha antiga
- Consultar na aba da reclamação
Se tiver retorno, abrir modal para


*/
