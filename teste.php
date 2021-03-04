<?php
ini_set('error_reporting', E_ERROR);
require __DIR__ . '/vendor/autoload.php';
const PLAN_NOVA = '10n2MH8XvPFjtRjGiytuqwseyGDTtruHSh7ijlkceiFE';
const PLAN_ANTIGA = '1EJEL5-QDxx3G0cFlesd6hHO0YYQr7Ez6w9FJrRDD91Y';
const MKT = "11WcbSyDe-e6va61vxnvNg-XQBHjYK0HbqIor5kDllu8";
const PLAN_TRANSP = "1xJng89KWlqp2u8amXM2V1oekc_elxwiVjyGar8ePEyY";
//Reading data from spreadsheet.

function autentica()
{
  $client = new \Google_Client();

  $client->setApplicationName('Google Sheets and PHP');

  $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

  $client->setAccessType('offline');

  $client->setAuthConfig(__DIR__ . '/credentials.json');
  return $client;
}

function enviaGoogle()
{
  $client = autentica();
  $service = new Google_Service_Sheets($client);

  $range = $_POST['area'] . '!A1:H1';
  $values = [ //Pedido, CPF, Nome, reclamação, obs
    [
      date('d/m/Y'),
      $_SESSION['login'],
      $_POST['ticket'],
      $_POST['pedido'],
      $_POST['cpf'],
      $_POST['nome'],
      $_POST['Reclama'],
      $_POST['obs'],

    ],
  ];
  $body = new Google_Service_Sheets_ValueRange([
    'values' => $values
  ]);
  $params = [
    'valueInputOption' => 'USER_ENTERED'
  ];
  try {
    $service->spreadsheets_values->append(PLAN_NOVA, $range, $body, $params);
  } catch (Exception $e) {
    echo "<Script> console.log('erro append " . $e->getMessage() . "')</script>";
  }
}

function consultaGoogle($param)
{
  $client = autentica();

  $service = new Google_Service_Sheets($client);

  //busca
  if ($param == "ticket") {
    $range = "B2:B";
  } elseif ($param == 'cpf') {
    $range = "E2:E";
  } else {
    $range = "C2:C";
  }

  //pesquisa plan antiga
  $respAnt = $service->spreadsheets_values->get(PLAN_ANTIGA, $range);
  $values = $respAnt->getValues();
  //print_r($values);
  $search = $_POST['num'];
  $ret[] = [];
  $rangesAnt[] = [];
  $x = 0;

  /* Busca mais de um valor */
  for ($i = 0; $i < count($values); $i++) {
    if ($values[$i][0] == $search) {
      $ret[$x] = 2 + $i;
      $rangesAmt[$x] = "B" . $ret[$x] . ":I" . $ret[$x];
      $x++;
    }
  }
  if ($x == 0) { //nenhum retorno

  } elseif ($x == 1) { // 1 retorno

  } else { // mais de 1 retorno
    $param = array('ranges' => $rangesAnt);
    $responseAnt = $service->spreadsheets_values->batchGet(SPREADSHEET_ID, $param);
    print_r($responseAnt);
  }

  /* Busca mais de um valor */
  // $param = array('ranges' => $ranges);
  // $response = $service->spreadsheets_values->batchGet(SPREADSHEET_ID, $param);
  // print_r($response);

}



// SEARCH.php

require __DIR__ . '/vendor/autoload.php';
const SPREADSHEET_ID = '1EJEL5-QDxx3G0cFlesd6hHO0YYQr7Ez6w9FJrRDD91Y'; // Planilha Geral

//Reading data from spreadsheet.

$client = new \Google_Client();

$client->setApplicationName('Google Sheets and PHP');

$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

$client->setAccessType('offline');

$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);

// Teste busca
$range = "C2:C";
$response = $service->spreadsheets_values->get(SPREADSHEET_ID, $range);

$values = $response->getValues();
$search = "7666324320142";
$ret;
$ranges;
$x = 0;

for ($i = 0; $i < count($values); $i++) {
  if ($values[$i][0] == $search) {
    $ret[$x] = 2 + $i;
    $ranges[$x] = "B" . $ret[$x] . ":I" . $ret[$x];
    $x++;
  }
}
//$ranges = ["B69:I69, B812:I812, B814:I814, B1451:I1451"];
//print_r($ranges);
$param = array('ranges' => $ranges);
$response = $service->spreadsheets_values->batchGet(SPREADSHEET_ID, $param);
print_r($response[1]['values'][0]);
if (array_search($response[1]['values'][0], ['Rafaela'])) {
  print_r(array_search($response[1]['values'][0], ['Rafaela']));
} else {
  echo '<br> não é vazio, é ' . $response[1]['values'][0][4];
}






// $range = $_POST['area'].'!A1:H1';
//         $values = [ //Pedido, CPF, Nome, reclamação, obs
//             [
//               date('d/m/Y'),
//                 'Teste',
//                 $_POST['ticket'],
//                 $_POST['pedido'],
//                 $_POST['cpf'],
//                 $_POST['nome'],
//                 $_POST['Reclama'],
//                 $_POST['obs'],
                
//             ],
//         ];
//         $body = new Google_Service_Sheets_ValueRange([
//             'values' => $values
//         ]);
//         $params = [
//             'valueInputOption' => 'USER_ENTERED'
//         ];
       // $result = $service->spreadsheets_values->append(SPREADSHEET_ID, $range, $body, $params);
        //$sucess = "ok";
        //header("Location: index.php");
        
        //printf("%d cells appended.", $result->getUpdates()->getUpdatedCells());

        try {
          //$range = $this->area . '!A1:I1';
          // $values = [ //Pedido, CPF, Nome, reclamação, obs
          //   [
          //     date('d/m/Y'),
          //     $recall,
          //     $this->user,
          //     $this->ticket,
          //     $this->order,
          //     $this->cpf,
          //     $this->client,
          //     $this->problem,
          //     $this->action
    
          //   ],
          // ];
    
          $range = $_POST['area'] . '!A1:H1';
          $values = [ //Pedido, CPF, Nome, reclamação, obs
            [
              date('d/m/Y'),
              $_SESSION['login'],
              $_POST['ticket'],
              $_POST['pedido'],
              $_POST['cpf'],
              $_POST['nome'],
              $_POST['Reclama'],
              $_POST['obs'],
    
            ],
          ];
    
          $service = new Google_Service_Sheets($auth);
          $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
          ]);
          $params = [
            'valueInputOption' => 'USER_ENTERED'
          ];
    
         $result = $service->spreadsheets_values->append($this->PLAN_NOVA, $range, $body, $params);
          printf("%d cells appended.", $result->getUpdates()->getUpdatedCells());
        } catch (Exception $e) {
          echo "<Script> console.log('erro append " . $e->getMessage() . "')</script>";
       