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
    if (isset($_GET['materia'])) {
        $materia = $_GET['materia'];

        // Conexão com o banco de dados
        $conn = mysqli_connect("localhost", "root", "", "bancodeteste");
        mysqli_set_charset($conn, "utf8");  // exibir corretamente caracteres acentuados e outros caracteres especiais

        // Verificar se houve um erro ao conectar ao banco de dados
        if (!$conn) {
            die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
        }

        // Consulta SQL para obter valores distintos da coluna "assunto" para a matéria especificada
        $sql = "SELECT DISTINCT assunto FROM questoes WHERE materia = '$materia'";

        // Executar a consulta SQL
        $result = mysqli_query($conn, $sql);

        // Verificar se a consulta retornou algum resultado
        if (mysqli_num_rows($result) > 0) {
            // Exibir os valores distintos encontrados como links
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<a href="consulta-questoes.php?assunto=' . urlencode($row['assunto']) . '">' . htmlspecialchars($row['assunto']) . '</a><br>';
            }
        } else {
            echo "Não foram encontrados valores distintos na coluna 'assunto' para a matéria '$materia'";
        }

        // Fechar a conexão com o banco de dados
        mysqli_close($conn);
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            // Capturar o evento de clique nos links de matéria
            $('.assunto-link').on('click', function(e) {
                // Permitir que o evento padrão do link seja executado
                // Isso fará com que a página seja redirecionada para o link da matéria
                // Depois a consulta utilizando AJAX será realizada
                return true;
            });
        });

        // Capturar o evento de clique nos links de matéria após a página ter sido redirecionada
        $(document).on('click', '.assunto-link', function(e) {
            e.preventDefault(); // prevenir a ação padrão do link

            // Obter o valor da matéria do link clicado
            var questao = $(this).text();

            // Realizar a nova consulta utilizando AJAX
            $.ajax({
                url: 'consulta-questoes.php',
                method: 'GET',
                data: {
                    questao: questao
                },
                success: function(response) {
                    // Exibir os valores de assunto retornados
                    $('#questoes').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    </script>

</body>

</html>