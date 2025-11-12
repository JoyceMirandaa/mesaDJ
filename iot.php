<?php
$conexao = mysqli_connect('localhost', 'root', 'root', 'mesaDj');
if (!$conexao) {
    die('Erro na conexão: ' . mysqli_connect_error());
}
if (isset($_GET['nome_som'])) {
    $soundName = ($_GET['nome_som']);
    $insert_led = $conexao->prepare("INSERT INTO mesaDJ (tecla) VALUES (?)");
    $insert_led->bind_param("s", $soundName);
    if ($insert_led->execute()) {
        echo "SOM inserido com sucesso.<br>";
        echo $soundName;
    } else {
        echo "[ERRO] Falha ao inserir SOM.<br>";
    };
} else {
    echo "Erro: O parâmetro nome_som não foi recebido.";
}


mysqli_close($conexao);
?>
