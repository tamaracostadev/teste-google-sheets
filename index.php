<!DOCTYPE html>
<?php
ini_set('error_reporting', E_ERROR);
session_start();
if (!isset($_SESSION['login'])) {
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
  if (isset($_POST['check']) && $_POST['check'] == 1) {
    include('reclama.php');
  };
  if (isset($_POST['check']) && $_POST['check'] == 2) {
    echo "<Script>openRec(event, 'consulta');</Script>";
    include('consultar.php');
  };
  ?>
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
    <div id="atendimento" class="rec ">
      <div class="w3-container w3-blue-gray">

        <h2>Atendimento Knit </h2>
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
              <input class="w3-input w3-border " name="ticket" type="number" placeholder="Ticket" required>
              <br>
              <label class="w3-text-black" for='nome'><b>Pedido</b></label>
              <input class="w3-input w3-border " name="pedido" type="number" placeholder="Pedido" required><br>
              <label class="w3-text-black" for='cpf'><b>CPF</b></label>
              <input class="w3-input w3-border " name="cpf" type="text" placeholder="CPF" required>

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
              <textarea name="obs" class="w3-input w3-border "></textarea>
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
  <!-- <div id="modal" class="w3-modal ">
      <div class="w3-modal-content w3-animate-zoom ">
        <header class="w3-container w3-blue-gray">
          <span onclick="document.getElementById('modal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
          <h2 id="modalH2"></h2>
        </header>

        <div class="w3-container">
          <textarea name="temptxt" id="temptxt" class="w3-input w3-border big"></textarea>
        </div>

        <footer class="w3-container w3-blue-gray">
          <div class="w3-margin">
            <button class="w3-btn w3-white" type="button" id="copia">Copiar</button>
          </div>
        </footer>
      </div>
    </div> -->
</body>
<script src=./js/script.js></script>


</html>