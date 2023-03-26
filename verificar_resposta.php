<?php
// Conexão com o banco de dados
$conn = mysqli_connect("localhost", "root", "", "bancodeteste");
mysqli_set_charset($conn, "utf8"); // Exibir corretamente caracteres acentuados e outros caracteres especiais

if (isset($_POST['alternativa'])) {
$id = $_POST['question_id'];
$resposta_usuario = $_POST['alternativa'];

// Verificar se houve um erro ao conectar ao banco de dados
if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

// Consulta para verificar a resposta correta
$query = "SELECT resposta_correta FROM questoes WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$resposta_correta = $row['resposta_correta'];

// Verificar se a resposta está correta
if ($resposta_usuario == $resposta_correta) {
    echo "Parabéns, você acertou!";
} else {
    echo "Você errou a correta é" . $row['resposta_correta'] . "." . "Tente novamente.";
}

// Consulta para verificar se já existe uma resposta registrada
$query = "SELECT resposta_usuario FROM questoes WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $old_answer = $row['resposta_usuario'];
    if ($old_answer != null && $old_answer != '') {
        $new_answer = $old_answer . ',' . $resposta_usuario;
    } else {
        $new_answer = $resposta_usuario;
    }
    $query = "UPDATE questoes SET resposta_usuario = '$new_answer' WHERE id = $id";
    mysqli_query($conn, $query);
} else {
    $query = "INSERT INTO questoes (id, resposta_usuario) VALUES ($id, '$resposta_usuario')";
    mysqli_query($conn, $query);
}

} else {
echo "Nenhuma alternativa foi selecionada.";
}