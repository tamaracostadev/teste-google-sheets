<?php
require __DIR__ . '/vendor/autoload.php';

class Autentica
{
  private $PLAN_NOVA = '10n2MH8XvPFjtRjGiytuqwseyGDTtruHSh7ijlkceiFE';
  private $PLAN_ANTIGA = '1EJEL5-QDxx3G0cFlesd6hHO0YYQr7Ez6w9FJrRDD91Y';
  private $MKT = "11WcbSyDe-e6va61vxnvNg-XQBHjYK0HbqIor5kDllu8";
  private $PLAN_TRANSP = "1xJng89KWlqp2u8amXM2V1oekc_elxwiVjyGar8ePEyY";
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

  function insertProblem($recall, $auth)
  {
    $service = new Google_Service_Sheets($auth);

    $range = $this->area . '!A1:H1';
    $values = [ //Pedido, CPF, Nome, reclamação, obs
      [
        date('d/m/Y - H:i:s'),
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
    $body = new Google_Service_Sheets_ValueRange([
      'values' => $values
    ]);
    $params = [
      'valueInputOption' => 'USER_ENTERED'
    ];
    try {
      if ($service->spreadsheets_values->append($this->PLAN_NOVA, $range, $body, $params)) {
        return 1;
      }
    } catch (Exception $e) {
      echo "<Script> console.log('erro append " . $e->getMessage() . "')</script>";
    }
  }
  //Função inserir atendimento
  function insertNew($auth, $action)
  {
    if ($action == 1) {
      $this->action = "Inserido na Planilha";
    }
    $service = new Google_Service_Sheets($auth,);
    $range = $this->area . '!A1:I1';
    $values = [ //Pedido, CPF, Nome, reclamação, obs
      [
        date('d/m/Y - H:i:s'),
        $this->origin,
        $this->ticket,
        $this->order,
        $this->cpf,
        $this->problem,
        $this->action,
        $this->user,
        $this->area

      ],
    ];
    $body = new Google_Service_Sheets_ValueRange([
      'values' => $values
    ]);
    $params = [
      'valueInputOption' => 'USER_ENTERED'
    ];
    try {
      if ($service->spreadsheets_values->append($this->PLAN_NOVA, $range, $body, $params)) {
        return 1;
      }
    } catch (Exception $e) {
      echo "<Script> console.log('erro append " . $e->getMessage() . "')</script>";
    }
  }
  //Função consulta planilha antiga
  //Consulta planilha nova (Atendimento)
  //Consulta aba plan nova
  //Consulta planilha antiga


}
