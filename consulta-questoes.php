<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questões</title>
</head>

<body>

    <?php

    if (isset($_GET['assunto'])) {
        $assunto =  $_GET['assunto'];

        // Conexão com o banco de dados
        $conn = mysqli_connect("localhost", "root", "", "bancodeteste");
        mysqli_set_charset($conn, "utf8");  // exibir corretamente caracteres acentuados e outros caracteres especiais

        // Verificar se houve um erro ao conectar ao banco de dados
        if (!$conn) {
            die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
        }

        // Consulta SQL para obter valores distintos da coluna "id" para a matéria especificada
        $sql = "SELECT DISTINCT link FROM questoes WHERE assunto = '$assunto'";

        // Executar a consulta SQL
        $result = mysqli_query($conn, $sql);

        // Verificar se a consulta retornou algum resultado
        if (mysqli_num_rows($result) > 0) {
            // Exibir os valores distintos encontrados como links
            $ids = '';
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['link'];

                // Concatena o valor de $id no final da string $ids
                $ids .= $id . ',';
                echo '<a href="transicao.php?questao=' . urlencode($row['link']) . '&link=' . $assunto . '">' . htmlspecialchars($row['link']) . '</a><br>';
            }
            $ids = rtrim($ids, ',');
        } else {
            echo "Não foram encontrados valores distintos na coluna 'id' para a matéria '$assunto'";
        }

        // Fechar a conexão com o banco de dados
        mysqli_close($conn);
    }

    ?>

</body>

</html>