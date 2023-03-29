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
    header('Content-Type: text/html; charset=utf-8');

    // Conexão com o banco de dados
    $conn = mysqli_connect("localhost", "root", "", "bancodeteste");
    mysqli_set_charset($conn, "utf8");  // exibir corretamente caracteres acentuados e outros caracteres especiais

    $materia = 'Administração de Recursos Materiais';

    // Verificar se houve um erro ao conectar ao banco de dados
    if (!$conn) {
        die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
    }

    echo "<table>";
    echo "<thead><tr><th>Assunto</th><th>Dificuldade</th><th>Quantidade</th></tr></thead>";
    echo "<tbody>";

    $sql1 = "SELECT DISTINCT materia FROM questoes";
    $result1 = mysqli_query($conn, $sql1);

    while ($row1 = mysqli_fetch_assoc($result1)) {
        $materia = $row1['materia'];

        $sql = "SELECT assunto, link, acertos, erros FROM questoes WHERE materia = '$materia' GROUP BY assunto, link";
        $result = mysqli_query($conn, $sql);

        $assuntos = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $assunto = $row['assunto'];
            $link = $row['link'];
            $acertos = $row['acertos'];
            $erros = $row['erros'];
            $nivel_dificuldade = ($acertos + (2 * $erros)) / 100;
            $assuntos[$assunto][$link] = $nivel_dificuldade;
        }

        $niveis_por_assunto = array();
        $soma_niveis = 0;
        $soma_niveis_vezes = 0;
        $resulado = -1;

        foreach ($assuntos as $assunto => $links) {

            $nivel_01 = 0;
            $nivel_02 = 0;
            $nivel_03 = 0;
            $nivel_04 = 0;
            $nivel_05 = 0;

            foreach ($links as $nivel) {

                if ($nivel >= 1 && $nivel < 1.2) {
                    $nivel_01 = $nivel_01 + 1;
                } elseif ($nivel >= 1.2 && $nivel < 1.4) {
                    $nivel_02 = $nivel_02 + 1;
                } elseif ($nivel >= 1.4 && $nivel < 1.6) {
                    $nivel_03 = $nivel_03 + 1;
                } elseif ($nivel >= 1.6 && $nivel < 1.8) {
                    $nivel_04 = $nivel_04 + 1;
                } elseif ($nivel >= 1.8) {
                    $nivel_05 = $nivel_05 + 1;
                } else {
                    $anulada = $nivel_05 + 1;
                }
            }

            if ($nivel_01 + $nivel_02 + $nivel_03 + $nivel_04 + $nivel_05 > 0) {
                $nivel_dificuldade_assunto = ($nivel_01 + ($nivel_02 * 2) + ($nivel_03 * 3) + ($nivel_04 * 4) + ($nivel_05 * 5)) / ($nivel_01 + $nivel_02 + $nivel_03 + $nivel_04 + $nivel_05);

                $soma_niveis =  $soma_niveis + $nivel_dificuldade_assunto;
                $soma_niveis_vezes =  $soma_niveis_vezes + 1;

                $resulado = $soma_niveis / $soma_niveis_vezes;
            } else {
                $nivel_dificuldade_assunto = 0;
            }
        }

        if ($resulado >= 0) {
            echo "<tr>";
            echo '<td><a href="consulta-assuntos.php?materia=' . urlencode($materia) . '">' . htmlspecialchars($materia) . '</a></td>';
            echo '<td>' .  number_format($resulado, 2) . '</td>';
            echo '<td> ' .  number_format($soma_niveis_vezes, 0) . '</td>';
            echo "</tr>";
        }
    }

    echo "</tbody>";
    echo "</table>";


    // Fechar a conexão com o banco de dados
    mysqli_close($conn);

    ?>



















    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            // Capturar o evento de clique nos links de matéria
            $('.materia-link').on('click', function(e) {
                // Permitir que o evento padrão do link seja executado
                // Isso fará com que a página seja redirecionada para o link da matéria
                // Depois a consulta utilizando AJAX será realizada
                return true;
            });

            // Capturar o evento de clique nos links de matéria após a página ter sido redirecionada
            $(document).on('click', '.materia-link', function(e) {
                e.preventDefault(); // prevenir a ação padrão do link

                // Obter o valor da matéria do link clicado
                var materia = $(this).text();

                // Realizar a nova consulta utilizando AJAX
                $.ajax({
                    url: 'consulta-assuntos.php',
                    method: 'GET',
                    data: {
                        materia: materia
                    },
                    success: function(response) {
                        // Exibir os valores de assunto retornados
                        $('#assuntos').html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });
        });
    </script>

    <div id="assuntos"></div>



</body>

</html>