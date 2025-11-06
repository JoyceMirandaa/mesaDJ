<?php
// Conexão com o banco
$conexao = mysqli_connect('paparella.com.br', 'paparell_aluno_3', '@Senai2025', 'paparell_iot');
if (!$conexao) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

// Recebe parâmetros da URL
$estado_led = isset($_GET['estado']) ? intval($_GET['estado']) : 0;
$valor = isset($_GET['valor']) ? intval($_GET['valor']) : 0;
$nome_aluno = "Joyce";

echo "Estado recebido: $estado_led<br>";
echo "Valor recebido (ultrassom): $valor<br>";

// ======== LED ========
$query = $conexao->prepare("SELECT id_led FROM led WHERE nome_aluno = ?");
$query->bind_param("s", $nome_aluno);
$query->execute();
$result = $query->get_result();
$row_led = $result->fetch_assoc();

if ($row_led) {
    $id_led = $row_led['id_led'];
    $update_led = $conexao->prepare("UPDATE led SET estado_led = ? WHERE id_led = ?");
    $update_led->bind_param("ii", $estado_led, $id_led);
    if ($update_led->execute()) {
        echo "LED atualizado com sucesso.<br>";
    } else {
        echo "[ERRO] Falha ao atualizar LED.<br>";
    }
} else {
    $insert_led = $conexao->prepare("INSERT INTO led (nome_aluno, estado_led) VALUES (?, ?)");
    $insert_led->bind_param("si", $nome_aluno, $estado_led);
    if ($insert_led->execute()) {
        echo "LED inserido com sucesso.<br>";
    } else {
        echo "[ERRO] Falha ao inserir LED.<br>";
    }
}

// ======== ULTRASSOM ========
$query = $conexao->prepare("SELECT id_ultrassom FROM ultrassom WHERE valor_cm = ?");
$query->bind_param("si", $valor, $nome_aluno);
$query->execute();
$result = $query->get_result();
$row_ultra = $result->fetch_assoc();

mysqli_close($conexao);
?>
