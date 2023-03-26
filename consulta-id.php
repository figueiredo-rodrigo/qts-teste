<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="/estilo.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<title>Visualização de Questões</title>

</head>

<body class="my-style">

	<?php
	// Conexão com o banco de dados
	$conn = mysqli_connect("localhost", "root", "", "bancodeteste");
	mysqli_set_charset($conn, "utf8");  // exibir corretamente caracteres acentuados e outros caracteres especiais

	// Verificar se houve um erro ao conectar ao banco de dados
	if (!$conn) {
		die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
	}

	// Verificar se o ID da questão foi enviado
	if (isset($_GET['id'])) {

		// Código para exibir a questão e as alternativas
		$id = $_GET['id'];

		// Buscar a questão no banco de dados
		$sql = "SELECT * FROM questoes WHERE link = $id";
		$result = mysqli_query($conn, $sql);

		// Exibe as informações da questão
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			echo '<h4 class="informacoes-questao">ID: ' . $row['link'] . '</h2>';
			echo '<p class="informacoes-questao">Matéria: ' . $row['materia'] . '</p>';
			echo '<p class="informacoes-questao">Assunto: ' . $row['assunto'] . '</p>';
			echo '<p class="informacoes-questao">Banca: ' . $row['banca'] . '</p><br>';

			// Exibir a questão e as alternativas
			echo '<div class="border border-primary rounded p-2 informacoes-questao">';
			echo nl2br($row['enunciado']);
			echo '</div>';

			// Exibir as alternativas
			for ($i = 1; $i <= 5; $i++) {
				$alternativa = $row['alternativa' . $i];
				if (!empty($alternativa)) {
					echo '<label>';
					echo '<div class="alternativa">';
					echo '<input class="radio" type="radio" name="alternativa" value="' . strtolower(chr($i + 96)) . '">';
					echo '<div class="alternativa-letra">';
					echo '<span class="letra">' . strtoupper(chr($i + 96)) . '</span>';
					echo '</div>';
					echo '<span id="alternativa-' . strtolower(chr($i + 96)) . '" class="alternativa-texto">' . nl2br($alternativa) . '</span>';
					echo '</div>';
					if ($alternativa_selecionada == strtolower(chr($i + 96))) {
						echo ' class="alternativa-selecionada"';
					}
					echo '</label>';
				}
			}
		}
	}

	// Fechar a conexão com o banco de dados
	mysqli_close($conn);
	?>

</body>

</html>