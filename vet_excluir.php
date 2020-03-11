<?php
  require_once('utils/utils.php');
  $conexao = criarConexao();
  $sql = 'DELETE FROM veterinario where codigo = :codigo';
  $comando = executaPrepare($sql);
  executaBindParam($comando);
  executaComando($comando);
  header('Location: vet_lista.php');
?>