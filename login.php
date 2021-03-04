<!DOCTYPE html>
<?php
session_start();
if (isset($_POST['login'])) {
  $_SESSION['login'] = $_POST['login'];
  $_SESSION['origem'] = $_POST['origem'];
  header('location:index.php');
}
?>
<html lang='pt-br'>

<head>
  <meta charset='utf-8'>
  <title>Knit Templates</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel='stylesheet' href='./css/w3.css'>
  <link rel='stylesheet' href='./css/style.css'>
  <script>
    document.documentElement.classList.add('js')
  </script>
</head>

<body>

  <div class="w3-card-4 w3-col l4 w3-display-middle">
    <div class="w3-container w3-blue-gray">
      <h2>Atendimento Knit</h2>
    </div>
    <form class="w3-container" method="POST" action="login.php" name="login" id="login">
      <div class="w3-section">
        <label class="w3-text-blue-gray" for='login'><b>Quem é Você?</b></label>
        <input class="w3-input w3-border " name="login" id="login" type="text" placeholder="Seu nome" required>
        <label class="w3-text-blue-gray" for='origem'><b>Quem é Você?</b></label>
        <input class="w3-input w3-border " name="origem" id="origem" type="text" placeholder="Seu nome" required>
        <br>
        <button class="w3-btn w3-blue-gray" type="submit" id="btn-ver">Enviar</button>

      </div>
    </form>
  </div>

</body>
<script src=./js/script.js></script>

</html>