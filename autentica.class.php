<?php
require __DIR__ . '/vendor/autoload.php';

class Autentica
{
  private $PLAN_NOVA = ''; //id das planilhas
  private $PLAN_ANTIGA = '';
  private $MKT = "";
  private $PLAN_TRANSP = "";
  private $recTransp = ["testeT", "Correção ou Confirmação de endereço", "Pedido entregue, mas cliente não recebeu", "Outros problemas com a transportadora", "Pedido extraviado"];
  private $urgent = ["TesteU", "Cancelamento antes do envio", "Número do pedido", "Envio NF", "Alteração antes do envio", "Troca de itens faltantes"];
  private $tf = ["Testet", "Erro troque fácil", "Outros problemas troque fácil"];
  private $itens = ["Testet", "Pedido com itens faltantes", "Pedido com itens errados"];
  private $envio = ["Testet", "Rastreio não funciona", "Pedido não enviado"];
  public $user;
  public $origin;
  public $ticket;
  public $order;
  public $cpf;
  public $client;
  public $action;
  public $problem;
  public $googleAuth;
  public $area;

  function auth()
  {
    $this->googleAuth = new \Google_Client();
    try {
      $this->googleAuth->setApplicationName('Atendimento Knit');

      $this->googleAuth->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

      $this->googleAuth->setAccessType('offline');

      $this->googleAuth->setAuthConfig(__DIR__ . '/credentials.json');
      return $this->googleAuth;
    } catch (Exception $e) {
      echo "<Script> console.log('erro auth " . $e->getMessage() . "')</script>";
    }
  }
  //Funcionando ok
  function getPostRec($user, $origin, $ticket, $order, $cpf, $client, $action, $problem, $area)
  {
    $this->user = $user;
    $this->origin = $origin;
    $this->ticket = $ticket;
    $this->order = $order;
    $this->cpf = $cpf;
    $this->client = $client;
    $this->action = $action;
    $this->problem = $problem;
    $this->area = $area;
  }

  //function setSession - Passa os dados para a sessão
  function setSession()
  {
    $_SESSION['user'] = $this->user;
    $_SESSION['origin'] = $this->origin;
    $_SESSION['ticket'] = $this->ticket;
    $_SESSION['order'] = $this->order;
    $_SESSION['cpf'] = $this->cpf;
    $_SESSION['client'] = $this->client;
    $_SESSION['action'] = $this->action;
    $_SESSION['problem'] = $this->problem;
    $_SESSION['area'] = $this->area;
  }
  function getSession()
  {
    $this->user = $_SESSION['user'];
    $this->origin = $_SESSION['origin'];
    $this->ticket = $_SESSION['ticket'];
    $this->order = $_SESSION['order'];
    $this->cpf = $_SESSION['cpf'];
    $this->client = $_SESSION['client'];
    $this->action = $_SESSION['action'];
    $this->problem = $_SESSION['problem'];
    $this->area = $_SESSION['area'];
  }
  function unsetSession()
  {
    unset($_SESSION['user'], $_SESSION['origin'], $_SESSION['ticket'], $_SESSION['order'], $_SESSION['cpf'], $_SESSION['client'], $_SESSION['action'], $_SESSION['problem'], $_SESSION['area']);
  }

  function insertProblem($recall, $auth, $insere)
  {
    $service = new Google_Service_Sheets($auth);
    //última linha da pla atendimento
    $lin = $service->spreadsheets_values->get($this->PLAN_NOVA, 'atendimentos!L1');
    //colocar if para alterar aba/planilha
    if ($this->area == 'Mkt') {

      $plan = $this->MKT;
      $range = 'A1:B1';
      $values = [ //Pedido, CPF, Nome, reclamação, obs
        [
          date('d/m/Y - H:i'),
          $this->action
        ],
      ];
    } else {
      if ($this->area == 'Outras') {
        $range = $this->area . '!A1:H1';
        $plan = $this->PLAN_NOVA;
        $area = $this->area;
        $this->problem = 'Outras Reclamações';
        $values = [ //Pedido, CPF, Nome, reclamação, obs
          [
            date('d/m/Y - H:i'),
            $recall,
            $this->user,
            $this->ticket,
            $this->order,
            $this->cpf,
            $this->client,
            $this->action

          ],
        ];
      } else {
        $area = $this->area;
        $range = $this->area . '!A1:H1';

        $plan = $this->PLAN_NOVA;
        //Validação urgente ou transp
        if (array_search($this->problem, $this->recTransp)) {
          $plan = $this->PLAN_TRANSP;
          $range = "A1:H1";
          $area = "Transportadora";
        } elseif (array_search($this->problem, $this->urgent)) {
          $range = 'Urgente!A1:H1';
          $area = "Urgente";
        } elseif (array_search($this->problem, $this->tf)) {
          $range = 'TroqueFacil!A1:H1';
          $area = "TroqueFacil";
        } elseif (array_search($this->problem, $this->itens)) {
          $range = 'Itens!A1:H1';
          $area = "Itens";
        } elseif (array_search($this->problem, $this->envio)) {
          $range = 'Envio!A1:H1';
          $area = "Envio";
        }
        if ($this->area == "Trocas" && $this->problem == "Defeito") {
          $range = 'Defeito!A1:H1';
          $area = "Defeito";
        }


        //Fim Validação urgente ou transp
        $values = [ //Pedido, CPF, Nome, reclamação, obs
          [
            date('d/m/Y - H:i'),
            $recall,
            $this->user,
            $this->ticket,
            $this->order,
            $this->cpf,
            $this->client,
            $this->problem,
            $this->action

          ],
        ];
      }
    }

    //param aba atendimento
    $rangeNew = 'atendimentos!A1:K1';
    $act = $this->action;
    if ($insere == 1) {
      $area = "";
    }
    $formula = '=Seerro(PROCV(C' . $lin["values"][0][0] . ';INDIRETO(J' . $lin["values"][0][0] . '&"!D:J");7;0);"Não está na planilha")';
    $responsavel = '=Seerro(PROCV(J' . $lin["values"][0][0] . ';AUX!A:B;2;0);"")';
    $valuesNew = [
      [
        date('d/m/Y - H:i'),
        $this->origin,
        $this->ticket,
        $this->order,
        $this->cpf,
        $this->problem,
        $act,
        $this->user,
        $formula,
        $area,
        $responsavel

      ],
    ];

    $body = new Google_Service_Sheets_ValueRange([
      'values' => $values
    ]);
    $params = [
      'valueInputOption' => 'USER_ENTERED'
    ];

    $bodyNew = new Google_Service_Sheets_ValueRange([
      'values' => $valuesNew
    ]);

    try {
      if ($this->area != "Mkt") {
        $service->spreadsheets_values->append($this->PLAN_NOVA, $rangeNew, $bodyNew, $params);
      }
      if ($insere != 1 || $this->area == "Mkt") {
        $service->spreadsheets_values->append($plan, $range, $body, $params);
      }

      return 1;
    } catch (Exception $e) {
      print_r($insere);
      echo "<hr>";
      print_r($values);
      echo "</br><br>";
      print_r($valuesNew);
      echo "</br>";
      print_r($e->getMessage());
    }
  }

  /** Função para consultar na planilha antiga [Funcionando ok]
   * @access public 
   * @param String $search (Valor a ser pesquisado) 
   * @param String $param (Parâmetro de busca)
   * @param Object $auth  (Autenticação Sheets API)
   * @return void 
   * */
  function lookOld($param, $auth, $search)
  {
    $service = new Google_Service_Sheets($auth);

    if ($param == 'cpf') { // Busca CPF
      $range = "E2:E";
    } elseif ($param == 'ticket') { // Busca Ticket
      $range = "B2:B";
    } else { // Busca Pedido
      $range = "C2:C";
    }
    $response = $service->spreadsheets_values->get($this->PLAN_ANTIGA, $range);
    $values = $response->getValues();
    $x = 0;
    for ($i = 0; $i < count($values); $i++) {
      if ($values[$i][0] == $search) {
        $ret[$x] = 2 + $i;
        $ranges[$x] = "B" . $ret[$x] . ":I" . $ret[$x];
        $x++;
      }
    }
    //RETORNA CABEÇALHO
    $cabecalho = $service->spreadsheets_values->get($this->PLAN_ANTIGA, "B1:I1");
    //Verifica se tem retorno
    if ($x == 1) { // 1 retorno
      $response = $service->spreadsheets_values->get($this->PLAN_ANTIGA, $ranges[0]);
      $response['retornos'] = 1;
      $response['cabecalhos'] = $cabecalho['values'][0];
      return $response;
    } elseif ($x > 1) { //mais de 1 retorno
      $param = array('ranges' => $ranges);
      $response = $service->spreadsheets_values->batchGet($this->PLAN_ANTIGA, $param);
      $response['retornos'] = $x;
      $response['cabecalhos'] = $cabecalho['values'][0];
      return $response;
    } else {
      return 0;
    }
  }

  /** Função para consultar na planilha nova (aba atendimentos)
   * @access public 
   * @param String $search (Valor a ser pesquisado) 
   * @param String $param (Parâmetro de busca)
   * @param Object $auth  (Autenticação Sheets API)
   * @return void 
   * */
  public function lookAll($param, $auth, $search)
  {
    $service = new Google_Service_Sheets($auth);

    if ($param == 'cpf') { // Busca CPF
      $range = "atendimentos!E2:E";
    } elseif ($param == 'ticket') { // Busca Ticket
      $range = "atendimentos!C2:C";
    } else { // Busca Pedido
      $range = "atendimentos!D2:D";
    }
    $response = $service->spreadsheets_values->get($this->PLAN_NOVA, $range);
    $values = $response->getValues();
    $x = 0;
    for ($i = 0; $i < count($values); $i++) {
      if ($values[$i][0] == $search) {
        $ret[$x] = 2 + $i;
        $ranges[$x] = "atendimentos!A" . $ret[$x] . ":K" . $ret[$x];
        $x++;
      }
    }
    //RETORNA CABEÇALHO
    $cabecalho = $service->spreadsheets_values->get($this->PLAN_NOVA, "atendimentos!A1:K1");
    //Verifica se tem retorno
    if ($x == 1) { // 1 retorno
      $response = $service->spreadsheets_values->get($this->PLAN_NOVA, $ranges[0]);
      $response['retornos'] = 1;
      $response['cabecalhos'] = $cabecalho['values'][0];
      return $response;
    } elseif ($x > 1) { //mais de 1 retorno
      $param = array('ranges' => $ranges);
      $response = $service->spreadsheets_values->batchGet($this->PLAN_NOVA, $param);
      $response['retornos'] = $x;
      $response['cabecalhos'] = $cabecalho['values'][0];
      return $response;
    } else {
      return 0;
    }
  }
}
