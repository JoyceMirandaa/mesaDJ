<?php
$conexao = mysqli_connect('localhost', 'root', 'root', 'mesaDj');
if (!$conexao) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $nome_som = $_GET['valorBotao'];

    $insert_led = $conexao->prepare("INSERT INTO mesaDJ (nome_som) VALUES (?)");
    $insert_led->bind_param("si", $nome_som);
    if ($insert_led->execute()) {
        echo "SOM inserido com sucesso.<br>";
        echo $nome_som;
    } else {
        echo "[ERRO] Falha ao inserir SOM.<br>";
    };
};

mysqli_close($conexao);
?>
