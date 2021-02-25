<!DOCTYPE html>
<?php include("envia.php");
?>
<html lang='pt-br'>

<head>
  <meta charset='utf-8'>
  <title>Knit Templates</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel='stylesheet' href='./css/w3.css'>
  <link rel='stylesheet' href='./css/style.css'>
  <script>document.documentElement.classList.add('js')</script>
</head>

<body>

  <div class="w3-card-4 w3-col l6 w3-display-topmiddle">
    <div class="w3-container w3-blue-gray">
      <h2>Atendimento Knit</h2>
    </div>
    <form class="w3-container" method="POST" action="index.php" name="cliform">
      <div class="w3-section">
        <label class="w3-text-blue-gray" for='nome'><b>Nome Cliente</b></label>
        <input class="w3-input w3-border " name="nome" id="nome" type="text" placeholder="Cliente" required>
        <div class="w3-section">
          <label class="w3-text-blue-gray"><b>Área Solicitação</b></label><br>
          <input class="w3-check" type="radio" name="tiporec" value="0">
          <label>Entrega</label>
          <input class="w3-check w3-margin-left" type="radio" name="tiporec" value="1">
          <label>Troca</label>
          <input class="w3-check w3-margin-left" type="radio" name="tiporec" value="2">
          <label>Financeiro</label>
          <input class="w3-check w3-margin-left" type="radio" name="tiporec" value="3">
          <label>Outras reclamações</label>
          <input class="w3-check w3-margin-left" type="radio" name="tiporec" value="4">
          <label>Dúvidas</label>
        </div>
        <div id="divSelrec">
          <label class="w3-text-blue-gray" for='nome'><b id='labelRec'></b></label>
          <!-- Select Reclama-->
          <div id="selreclama" class="w3-section hid">
            <label class="w3-text-blue-gray" for="Reclama"><b>Tipo de Reclamação</b></label>
            <select class="w3-select w3-border" name="Reclama" id="Reclama">
              <option value="" disabled selected>Selecione a reclamação</option>
            </select>
          </div>
          <div id="infoRec" class="w3-section hid">
            <label class="w3-text-blue-gray" for='nome'><b>Ticket</b></label>
            <input class="w3-input w3-border " name="ticket" type="number" placeholder="Ticket" required>
            <br>
            <label class="w3-text-blue-gray" for='nome'><b>Pedido</b></label>
            <input class="w3-input w3-border " name="pedido" type="number" placeholder="Pedido" required>
          </div>

          <div id="obsRec" class="w3-section hid">
            <label class="w3-text-blue-gray" for=""><b>Observação</b></label>
            <textarea name="obs" class="w3-input w3-border "></textarea>
          </div>
        </div>
        <div class="w3-section hid">
          <label class="w3-text-blue-gray" for="Template"><b>Selecione o template</b></label>
          <select class="w3-select w3-border" name="Template" id="Template">
            <option value="" disabled selected>Selecione o template</option>
          </select>
        </div>
        <div class="w3-section hid">
          <label class="w3-text-blue-gray"><b>Modificações</b></label><br>
          <input class="w3-check" type="checkbox" name="mod" value="0">
          <label>Atraso expedição</label>
          <input class="w3-check" type="checkbox" name="mod" value="1">
          <label>Demora no retorno</label>
        </div>
        <br><br>
        <button class="w3-btn w3-blue-gray" type="button" id="btn-ver">Ver template</button>

      </div>
    </form>
  </div>

  <!-- modal template -->
  <div id="modal" class="w3-modal ">
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
  </div>
</body>
<script src=./js/script.js></script>

</html>