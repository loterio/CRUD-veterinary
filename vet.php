<?php
require_once('assets/conf/functions.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
  $formulario = file_get_contents('vet.html');
  if (isset($_GET['codigo'])) {
    $conexao = criarConexao();
    $sql = 'SELECT * FROM veterinario where codigo = :codigo';
    $comando = executaPrepare($sql);
    executaBindParam($comando);
    executaComando($comando);
    $veterinario = $comando->fetch();
    $formulario = preencherFormulario($formulario, $veterinario);
  }
  $dadosVazios = array("nome" => '', "crmv" => '', "telefone" => '', "codigo" => '', "imagem" => '');
  $formulario = preencherFormulario($formulario, $dadosVazios);
  print($formulario);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $conexao = criarConexao();

  $pasta = 'assets/img/';
  $temporario = $_FILES['imagem']['tmp_name'];
  $novoNome = uniqid().$_FILES['imagem']['name'];
  $linkRelativo = $pasta.$novoNome;
  move_uploaded_file($temporario, $linkRelativo);
  
  if ($_FILES['imagem']['name'] !== "") {
    $_POST['imagem'] = $linkRelativo;
    if ($_POST['imagemAnterior'] !== "")
      unlink($_POST['imagemAnterior']);
  }else {
    $_POST['imagem'] = $_POST['imagemAnterior'];
  }
    
  if ($_POST['codigo'] > 0) {
    $sql = 'UPDATE veterinario 
               SET nome = :nome, 
                   crmv = :crmv, 
                   telefone = :telefone,
                   imagem = :imagem  
             WHERE codigo = :codigo';
  } else {
    $sql = 'INSERT INTO veterinario
                   (nome, crmv, telefone, imagem) 
            VALUES (:nome, :crmv, :telefone, :imagem)';
  }
  $comando = executaPrepare($sql);
  executaBindParam($comando);
  executaComando($comando);
  header('Location: vet_lista.php');
}
?>
