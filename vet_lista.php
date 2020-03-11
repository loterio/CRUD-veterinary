<?php
    require_once('utils/utils.php');
    require_once('assets/conf/conf.inc.php');
    $conexao = new PDO(MYSQL,USER,PASSWORD);
    if (!$conexao) {
        die('Erro ao cenectar com o banco de dados...');
    }
    $sql = 'SELECT * FROM veterinario';
    $comando = executaPrepare($sql);
    executaComando($comando);
    $itens="";
    while ($linha = $comando->fetch(PDO::FETCH_ASSOC)) {
        $item = file_get_contents('vet_itens.html');
        $item = preencherFormulario($item, $linha);
        $itens .= $item; 
    }
    $lista = file_get_contents('vet_lista.html');
    $lista = str_replace('{itens}',$itens,$lista);
    print($lista);
?>