<?php
function preencherFormulario($formulario, $dados) {
  foreach ($dados as $chave => $valor)
    $formulario = str_replace('{' . $chave . '}', $valor, $formulario);
  return $formulario;
}

function criarConexao() {
  try {
    require_once('assets/conf/conf.inc.php');
    $conexao = new PDO(MYSQL, USER, PASSWORD);
    return $conexao;
  } catch (PDOException $e) {
    print('Erro ao conectar');
    die();
  } catch (Exception $e) {
    print('Erro genérico. Entre em contato');
    die();
  }
}


function executaPrepare($sql) {
  try {
    $conexao = criarConexao();
    $comando = $conexao->prepare($sql);
    return $comando;
  } catch (Exception $e) {
    print('Erro ao executar comando. ' . $e->getMessage());
    die();
  }
}

function executaBindParam(&$comando) {
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && 
  $_SERVER['SCRIPT_NAME'] == "/programação 2/FAZENDA COM FUNCOES/vet.php") {
    $comando->bindParam(':nome', $_POST['nome']);
    $comando->bindParam(':crmv', $_POST['crmv']);
    $comando->bindParam(':telefone', $_POST['telefone']);
    $comando->bindParam(':imagem', $_POST['imagem']);
  }
  if (isset($_POST['codigo']) && $_POST['codigo'] !== '')
  $comando->bindParam(':codigo', $_POST['codigo']);
  if (isset($_GET['codigo']) && $_GET['codigo'] !== '')
  $comando->bindParam(':codigo', $_GET['codigo']);
}

function executaComando($comando) {
  try {
    $comando->execute();
    return $comando;
  } catch (Exception $e) {
    print('Erro ao executar comando. ' . $e->getMessage());
    die();
  }
}
?>
