<?php
  require_once('utils/utils.php');
  $formulario = file_get_contents('vet_detalhado.html');
  $conexao = criarConexao();
  $sql = 'SELECT * FROM veterinario where codigo = :codigo';
  $comando = executaPrepare($sql);
  executaBindParam($comando);
  executaComando($comando);
  $veterinario = $comando->fetch();
  $formulario = preencherFormulario($formulario, $veterinario);
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $botao = file_get_contents('btn_ex_vet.html');
    $botao = str_replace('{codigo}', $_GET['codigo'], $botao);
    $formulario = str_replace('{botao}', $botao, $formulario);
  }
  $formulario = str_replace('{botao}', '', $formulario);
  print($formulario);
?>  
