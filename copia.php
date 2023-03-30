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
	if (isset($_POST['id'])) {

		// Código para exibir a questão e as alternativas
		$id = $_POST['id'];

		// Buscar a questão no banco de dados
		$sql = "SELECT * FROM questoes WHERE id = $id";
		$result = mysqli_query($conn, $sql);

		// Realiza uma nova pesquisa
		echo '
		<form method="post">
			<label for="id">ID da questão:</label>
			<input type="text" name="id">
			<input type="submit" value="Buscar">
		</form>';

		// Exibe as informações da questão
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			echo '<h4 class="informacoes-questao">ID: ' . $row['id'] . '</h2>';
			echo '<p class="informacoes-questao">Matéria: ' . $row['materia'] . '</p>';
			echo '<p class="informacoes-questao">Assunto: ' . $row['assunto'] . '</p>';
			echo '<p class="informacoes-questao">Banca: ' . $row['banca'] . '</p><br>';


			// Exibir a questão e as alternativas
			echo '<div class="border border-primary rounded p-2 informacoes-questao">';
			echo nl2br($row['enunciado']);
			echo '</div>';

			echo '<div class="alternativas">';

			echo '<div class="border border-primary rounded p-2 informacoes-questao">';
			echo '<label class="alternativa">';
			echo '<input type="radio" name="alternativa" value="a">';
			echo '<span class="alternativa-letra">A</span>';
			echo '<span id="alternativa-a" class="alternativa-texto">' . nl2br($row['alternativa1']) . '</span>';
			echo '</label>';
			echo '</div>';

			echo '<div class="border border-primary rounded p-2 informacoes-questao">';
			echo '<label class="alternativa">';
			echo '<input type="radio" name="alternativa" value="b">';
			echo '<span class="alternativa-letra">B</span>';
			echo '<span id="alternativa-b" class="alternativa-texto">' . nl2br($row['alternativa2']) . '</span>';
			echo '</label>';
			echo '</div>';

			echo '<div class="border border-primary rounded p-2 informacoes-questao">';
			echo '<label class="alternativa">';
			echo '<input type="radio" name="alternativa" value="c">';
			echo '<span class="alternativa-letra">C</span>';
			echo '<span id="alternativa-c" class="alternativa-texto">' . nl2br($row['alternativa3']) . '</span>';
			echo '</label>';
			echo '</div>';

			echo '<div class="border border-primary rounded p-2 informacoes-questao">';
			echo '<label class="alternativa">';
			echo '<input type="radio" name="alternativa" value="d">';
			echo '<span class="alternativa-letra">D</span>';
			echo '<span id="alternativa-d" class="alternativa-texto">' . nl2br($row['alternativa4']) . '</span>';
			echo '</label>';
			echo '</div>';

			echo '<div class="border border-primary rounded p-2 informacoes-questao">';
			echo '<label class="alternativa">';
			echo '<input type="radio" name="alternativa" value="e">';
			echo '<span class="alternativa-letra">E</span>';
			echo '<span id="alternativa-e" class="alternativa-texto">' . nl2br($row['alternativa5']) . '</span>';
			echo '</label>';
			echo '</div>';

			echo '<div class="border border-primary rounded p-2 informacoes-questao">';
		}

		echo '
		<form id="form-resposta" method="post">
		<input type="hidden" name="question_id" value="' . $row["id"] . '">
		<button type="button" id="btn-verificar-resposta">Verificar resposta</button>
	</form>';
	} else {
		// Código para exibir o formulário
		echo '
			<form method="post">
				<label for="id">ID da questão:</label>
				<input type="text" name="id">
				<input type="submit" value="Buscar">
			</form>';
	}

	// Fechar a conexão com o banco de dados
	mysqli_close($conn);
	?>


	<script>
		$(document).ready(function() {
			$("#btn-verificar-resposta").click(function() {
				var respostaSelecionada = $('input[name="alternativa"]:checked');
				var respostaSelecionadaValor = respostaSelecionada.val();
				var questionId = $('input[name="question_id"]').val(); // Recupera o valor do input hidden
				$.ajax({
					url: "verificar_resposta.php",
					type: "post",
					data: {
						alternativa: respostaSelecionadaValor,
						question_id: questionId // Inclui o ID da questão nos dados enviados
					},
					success: function(result) {
						$("#resultado").html(result);
					}
				});
			});
		});

		let alternativaTextoA = document.querySelector("#alternativa-a");

		alternativaTextoA.addEventListener("dblclick", function() {
			if (alternativaTextoA.classList.contains("tachado")) {
				alternativaTextoA.classList.remove("tachado");
			} else {
				alternativaTextoA.classList.add("tachado");
			}
		});

		let alternativaTextoB = document.querySelector("#alternativa-b");

		alternativaTextoB.addEventListener("dblclick", function() {
			if (alternativaTextoB.classList.contains("tachado")) {
				alternativaTextoB.classList.remove("tachado");
			} else {
				alternativaTextoB.classList.add("tachado");
			}
		});

		let alternativaTextoC = document.querySelector("#alternativa-c");

		alternativaTextoC.addEventListener("dblclick", function() {
			if (alternativaTextoC.classList.contains("tachado")) {
				alternativaTextoC.classList.remove("tachado");
			} else {
				alternativaTextoC.classList.add("tachado");
			}
		});

		let alternativaTextoD = document.querySelector("#alternativa-d");

		alternativaTextoD.addEventListener("dblclick", function() {
			if (alternativaTextoD.classList.contains("tachado")) {
				alternativaTextoD.classList.remove("tachado");
			} else {
				alternativaTextoD.classList.add("tachado");
			}
		});

		let alternativaTextoE = document.querySelector("#alternativa-e");

		alternativaTextoE.addEventListener("dblclick", function() {
			if (alternativaTextoE.classList.contains("tachado")) {
				alternativaTextoE.classList.remove("tachado");
			} else {
				alternativaTextoE.classList.add("tachado");
			}
		});

		src = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
		integrity = "sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
		crossorigin = "anonymous"
	</script>


</body>

</html>