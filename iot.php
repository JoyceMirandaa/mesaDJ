<?php
$conexao = mysqli_connect('paparella.com.br', 'paparell_deejay', '@Senai2025', 'paparell_deejay');
if (!$conexao) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

if (isset($_GET['nome_som'])) {
    $soundName = ($_GET['nome_som']);
    $query = $conexao->prepare("SELECT id_som FROM sons WHERE nome_som = ?");
    $query->bind_param("s", $soundName);
    $query->execute();
    $result = $query->get_result();
    $row_som = $result->fetch_assoc();

    if ($row_som) {
        $id_som = $row_som['id_som'];
        $update_som = $conexao->prepare("UPDATE sons SET nome_som = ? WHERE id_som = ?");
        $update_som->bind_param("si", $soundName, $id_som);
        if ($update_som->execute()) {
            echo "LED atualizado com sucesso.<br>";
        } else {
            echo "[ERRO] Falha ao atualizar LED.<br>";
        }
    } else {
        $insert_som = $conexao->prepare("INSERT INTO sons (nome_som) VALUES (?)");
        $insert_som->bind_param("s", $soundName);
        if ($insert_som->execute()) {
            echo "LED inserido com sucesso.<br>";
        } else {
            echo "[ERRO] Falha ao inserir LED.<br>";
        }
    }
} else {
    echo "Erro: O parâmetro nome_som não foi recebido.";
}


mysqli_close($conexao);
?>
