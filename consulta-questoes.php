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
        $sql = "SELECT q.link, q.banca, q.ano, q.vezes_respondida, q.acertos, q.erros FROM questoes q JOIN (SELECT DISTINCT link FROM questoes WHERE assunto = '$assunto') q2 ON q.link = q2.link";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

            echo "<table>";
            echo "<thead><tr><th>Link</th><th>Banca</th><th>Ano</th><th>Acertos</th><th>Erros</th><th>Respondida</th><th>Índice</th></tr></thead>";
            echo "<tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                $link = $row['link'];
                $banca = $row['banca'];
                $ano = $row['ano'];
                $acertos = $row['acertos'];
                $erros = $row['erros'];
                $vezes_respondida = $row['vezes_respondida'];

                if ($vezes_respondida === null) {
                    $indice = 0;
                } else {
                    $indice = ($acertos + (2 * $erros)) / 100;
                }

                echo "<tr>";
                echo '<td><a href="transicao.php?questao=' . urlencode($link) . '&link=' . $assunto . '">' . htmlspecialchars($link) . '</a></td>';
                echo "<td>" . htmlspecialchars($banca) . "</td>";
                echo "<td>" . htmlspecialchars($ano) . "</td>";
                echo "<td>" . htmlspecialchars($acertos) . "</td>";
                echo "<td>" . htmlspecialchars($erros) . "</td>";
                echo "<td>" . htmlspecialchars($vezes_respondida) . "</td>";
                echo "<td>" . htmlspecialchars($indice) . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "Não foram encontrados valores distintos na coluna 'id' para a matéria '$assunto'";
        }

        mysqli_close($conn);
    }


    ?>

</body>

</html>