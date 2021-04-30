<!DOCTYPE html>
<?php
ini_set('error_reporting', E_ERROR);
session_start();
if (!isset($_SESSION['login']) || !isset($_SESSION['origem'])) {
  header('location:login.php');
}
?>
<html lang='pt-br'>

<head>
  <meta charset='utf-8'>
  <title>Knit Atendimento</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel='stylesheet' href='./css/w3.css'>
  <link rel='stylesheet' href='./css/style.css'>
  <script>
    document.documentElement.classList.add('js');

    function openRec(evt, rec) {
      var i, x, tablinks;
      x = document.getElementsByClassName("rec");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablink");
      for (i = 0; i < x.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" w3-border-red", "");
      }
      document.getElementById(rec).style.display = "block";
      evt.currentTarget.firstElementChild.className += " w3-border-red";
    }
  </script>
</head>

<body>
  <?php
  if (isset($_POST['check']) && ($_POST['check'] == 1 || $_POST['check'] == 3)) {
    include('reclama.php');
    //echo $insert;
    if ($insert == 1) { ?>
      <div class="w3-section w3-col l8 w3-display-topmiddle espaco">
        <div class="w3-panel w3-green w3-display-container">
          <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
          <h3>Sucesso</h3>
          <p>A reclamação foi inserida com sucesso.</p>
        </div>
      </div>
    <?php } elseif (!$ret && !$retorno) { ?>
      <div class="w3-section w3-col l8 w3-display-topmiddle espaco">
        <div class="w3-panel w3-red w3-display-container">
          <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
          <h3>Ops, Ocorreu um erro!</h3>
          <p>Tente novamente. Caso este erro persista, tire um print da tela e manda pra Tamara.</p>
        </div>
      </div>
    <?php   }
  };

  if (isset($_POST['check']) && $_POST['check'] == 2) {
    include('consultar.php');
    if (!$ret && !$retorno) {
    ?>
      <div class="w3-section w3-col l8 w3-display-topmiddle espaco">
        <div class="w3-panel w3-light-blue w3-display-container">
          <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
          <h3>Informação</h3>
          <p>Não há nenhum retorno para este <?php echo $_POST['consulta']; ?></p>
        </div>
      </div>
  <?php };
  } ?>
  <div class="w3-card-4 w3-col l6 w3-display-topmiddle espaco">
    <div class="w3-row w3-white">
      <a href="javascript:void(0)" onclick="openRec(event, 'atendimento');">
        <div class="w3-half tablink w3-bottombar w3-hover-light-grey w3-padding w3-border-red">Nova Reclamação</div>
      </a>
      <a href="javascript:void(0)" onclick="openRec(event, 'consulta');">
        <div class="w3-half tablink w3-bottombar w3-hover-light-grey w3-padding">Consulta Retorno</div>
      </a>
    </div>
    <!-- TAB RECLAMAÇÃO--->
    <div id="atendimento" class="rec">
      <div class="w3-container w3-blue-gray">

        <h2>Atendimento Knit - Nova Reclamação</h2>
      </div>
      <form class="w3-container" method="POST" action="index.php" name="cliform" id="cliform">
        <div class="w3-section">
          <label class="w3-text-black" for='nome'><b>Nome Cliente</b></label>
          <input class="w3-input w3-border " name="nome" id="nome" type="text" placeholder="Cliente" required>
          <div class="w3-section">
            <label class="w3-text-black"><b>Área Solicitação</b></label><br>
            <input class="w3-check" type="radio" name="tiporec" value="0">
            <label>Entrega</label>
            <input class="w3-check w3-margin-left" type="radio" name="tiporec" value="1">
            <label>Troca</label>
            <input class="w3-check w3-margin-left" type="radio" name="tiporec" value="2">
            <label>Financeiro</label>
            <input class="w3-check w3-margin-left" type="radio" name="tiporec" value="3">
            <label>Outras reclamações</label>
            <input class="w3-check w3-margin-left" type="radio" name="tiporec" value="4">
            <label>Retirar do MKT</label>
          </div>
          <div id="divSelrec">
            <label class="w3-text-black" for='nome'><b id='labelRec'></b></label>
            <!-- Select Reclama-->
            <div id="selreclama" class="w3-section hid">
              <label class="w3-text-black" for="Reclama"><b>Tipo de Reclamação</b></label>
              <select class="w3-select w3-border" name="Reclama" id="Reclama">
                <option value="" disabled selected>Selecione a reclamação</option>
              </select>
            </div>
            <div id="infoRec" class="w3-section hid">
              <label class="w3-text-black" for='nome'><b>Ticket</b></label>
              <input class="w3-input w3-border " name="ticket" id="ticket" type="number" placeholder="Ticket" required>
              <br>
              <label class="w3-text-black" for='nome'><b>Pedido</b></label>
              <input class="w3-input w3-border " name="pedido" id="pedido" type="number" placeholder="Pedido" required><br>
              <label class="w3-text-black" for='cpf'><b>CPF</b></label>
              <input class="w3-input w3-border " name="cpf" id="cpf" type="text" placeholder="CPF" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" \ title="Digite o CPF no formato: 000.000.000-00 Sem espaços" required>

              <div class="w3-section">
                <label class="w3-text-black"><b>Precisa colocar na planilha?</b></label><br>
                <input class="w3-check" type="radio" name="acao" value="0" checked>
                <label>Sim</label>
                <input class="w3-check w3-margin-left" type="radio" name="acao" value="1">
                <label>Não</label>

              </div>
            </div>


            <div id="obsRec" class="w3-section hid">
              <label class="w3-text-black" for=""><b>Ação necessária/ Ação efetuada</b></label>
              <textarea name="obs" class="w3-input w3-border " required></textarea>
            </div>
          </div>
          <input class='hid' name="check" value="1">
          <input class='hid' name="area" id="area">
          <br><br>
          <button class="w3-btn w3-blue-gray" type="submit" id="btn-ver">Enviar</button>

        </div>
      </form>
    </div>
    <!-TAB CONSULTA-->
      <div id="consulta" class="rec" style="display:none">
        <div class="w3-container w3-blue-gray">

          <h2>Atendimento Knit - Consulta retorno</h2>
        </div>

        <?php  ?>
        <form class="w3-container" method="POST" action="index.php" name="consform" id="consform">
          <div class="w3-section">
            <label class="w3-text-black"><b>Consultar por</b></label><br>
            <input class="w3-check" type="radio" name="consulta" value="cpf" checked>
            <label>CPF</label>
            <input class="w3-check w3-margin-left" type="radio" name="consulta" value="ticket">
            <label>Ticket</label>
            <input class="w3-check w3-margin-left" type="radio" name="consulta" value="pedido">
            <label>Pedido</label>

          </div>
          <div class="w3-section">
            <label class="w3-text-black" for='num'><b>Número</b></label>
            <input class="w3-input w3-border " name="num" id="num" type="text" placeholder="Número">

            <input class='hid' name="check" value="2">
            <br>
            <button class="w3-btn w3-blue-gray" type="submit" id="btn-ver">Enviar</button>
            <br>
          </div>
        </form>
      </div>

  </div>

  <!-- modal template -->
  <?php if ($retorno || $ret) { ?>
    <div id="modal" class="w3-modal " style="display: block;">
      <div class="w3-modal-content w3-animate-zoom ">
        <header class="w3-container w3-blue-gray">
          <span onclick="document.getElementById('modal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
          <h2 id="modalH2">Retorno consulta</h2>
        </header>

        <div class="w3-container">
          <h2> Retorno Planilha Nova</h2>

          <table class="w3-table-all w3-card-4">
            <?php
            //Header retorno plan antiga
            if (isset($itensNova['retornos']) && $itensNova['retornos'] == 1) { ?>
              <tr>
                <?php
                for ($i = 0; $i < count($itensNova['cabecalhos']); $i++) {
                  echo '<th>' . $itensNova["cabecalhos"][$i] . '</th>';
                }
                ?>
              </tr>
              <tr>
                <?php
                for ($i = 0; $i < count($itensNova['cabecalhos']); $i++) {
                  echo '<td>' . $itensNova["values"][0][$i] . '</td>';
                }
                ?>
              </tr>
            <?php } elseif (isset($itensNova['retornos']) && $itensNova['retornos'] > 1) { ?>
              <tr>
                <?php
                for ($i = 0; $i < count($itensNova['cabecalhos']); $i++) {
                  echo '<th>' . $itensNova["cabecalhos"][$i] . '</th>';
                }
                ?>
              </tr>

            <?php
              for ($x = 0; $x < count($itensNova['valueRanges']); $x++) {
                echo "<tr>";
                for ($i = 0; $i < count($itensNova['cabecalhos']); $i++) {
                  echo '<td>' . $itensNova['valueRanges'][$x]['values'][0][$i] . '</td>';
                }
                echo "</tr>";
              }
            }

            ?>
          </table>
          <?php if (!$ret) {
            echo '<P>Nenhum retorno encontrado na Planilha Nova</P>';
          } ?>
          <br>

          <!---Consulta plan Antiga ----->
          <h2> Retorno Planilha Antiga</h2>

          <table class="w3-table-all w3-card-4">
            <?php
            //Header retorno plan antiga
            if (isset($itensAnt['retornos']) && $itensAnt['retornos'] == 1) { ?>
              <tr>
                <?php
                for ($i = 0; $i < count($itensAnt['cabecalhos']); $i++) {
                  if ($i !== 5) {
                    echo '<th>' . $itensAnt["cabecalhos"][$i] . '</th>';
                  }
                }
                ?>
              </tr>
              <tr>
                <?php
                for ($i = 0; $i < count($itensAnt['cabecalhos']); $i++) {
                  if ($i !== 5) {
                    echo '<td>' . $itensAnt["values"][0][$i] . '</td>';
                  }
                }
                ?>
              </tr>
            <?php } elseif (isset($itensAnt['retornos']) && $itensAnt['retornos'] > 1) { ?>
              <tr>
                <?php
                for ($i = 0; $i < count($itensAnt['cabecalhos']); $i++) {
                  if ($i !== 5) {
                    echo '<th>' . $itensAnt["cabecalhos"][$i] . '</th>';
                  }
                }
                ?>
              </tr>

            <?php
              for ($x = 0; $x < count($itensAnt['valueRanges']); $x++) {
                echo "<tr>";
                for ($i = 0; $i < count($itensAnt['cabecalhos']); $i++) {
                  if ($i !== 5) {
                    echo '<td>' . $itensAnt['valueRanges'][$x]['values'][0][$i] . '</td>';
                  }
                }
                echo "</tr>";
              }
            }

            ?>
          </table>
          <?php if (!$retorno) {
            echo '<P>Nenhum retorno encontrado na Planilha Antiga</P>';
          } ?>
          <br>



        </div>

        <footer class="w3-container w3-blue-gray">
          <div class="w3-margin">




            <form method="POST" action="index.php" name="insereform" id="insereform">
              <div class="w3-container">

                <?php if (isset($_POST['check']) && $_POST['check'] == 1) { ?>
                  <input class='hid' name="check" value="3">
                  <button class="w3-btn w3-white w3-margin-right" type="submit">Inserir na planilha</button>
                <?php } ?>
                <button class="w3-btn w3-white" type="button" onclick="document.getElementById('modal').style.display='none'">Fechar</button>
              </div>
            </form>



          </div>
        </footer>
      </div>
    </div>
  <?php }
  if (isset($_POST['check']) && $_POST['check'] == 2) {
    echo "<Script>openRec(event, 'consulta');</Script>";
  };

  ?>
</body>
<script src=./js/script.js?vs=4></script>


</html>