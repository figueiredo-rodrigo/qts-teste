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
	if (isset($_GET['questao'])) {
		$id = $_GET['questao'];
		$link = $_GET['link'];
	}

	?>


	<!-- botão para avançar para a próxima questão -->
	<button id="proxima-questao">Próxima questão</button>

	<!-- script em JavaScript -->
	<script>
		// Quando o botão for clicado, execute a função a seguir
		var btnProximaQuestao = document.getElementById('proxima-questao');
		btnProximaQuestao.addEventListener('click', function() {

			// Busca as questões disponíveis
			fetch("http://localhost/consulta-questoes.php?assunto=<?php echo $link; ?>")
				.then(response => response.text())
				.then(html => {
					const parser = new DOMParser();
					const doc = parser.parseFromString(html, 'text/html');

					// Filtra as questões para encontrar a próxima
					const questoes = [...doc.querySelectorAll('[href^="transicao.php?questao="]')].filter(questao => {
						const idQuestao = questao.getAttribute('href').match(/(\d+)/)[1];
						return idQuestao > 0;
					});

					// Encontra o índice da próxima questão
					const numero = questoes.findIndex(questao => questao.getAttribute('href').match(/(\d+)/)[1] === "<?php echo $id; ?>");
					const id = questoes[numero + 1].getAttribute('href').match(/(\d+)/)[1];
					console.log(numero + 1)

					// Atualiza a página com a próxima questão
					location.replace('transicao.php?questao=' + id + '&link=' + "<?php echo $link; ?>");
				})
				.catch(error => console.log(error));

			// Limpa o resultado de verificação
			$('#resultado-verificacao').html('');
		});

		// Se houver um ID de questão definido, carrega a questão
		if ("<?php echo $id; ?>" !== 0) {
			console.log("<?php echo $id; ?>")

			$.ajax({
				url: 'consulta-id.php?id=' + "<?php echo $id; ?>",
				success: function(data) {
					$('#resultado').html(data);
				}
			});
		}
	</script>

	
	<div id="resultado"></div>

	<script>
		$('input[name="alternativa"]').on('change', function() {
			// Remove a classe .alternativa-selecionada de todas as alternativas
			$('.alternativa-letra').removeClass('alternativa-selecionada');

			// Adiciona a classe .alternativa-selecionada apenas na alternativa selecionada
			$(this).parent('label').find('.alternativa-letra').addClass('alternativa-selecionada');
		});
	</script>


	<form id="form-resposta" method="post">
		<input type="hidden" name="question_id" value="<?php echo $url; ?>">
		<button type="submit" id="btn-verificar-resposta">Verificar resposta</button>
	</form>

	<div id="resultado-verificacao"></div>




<script>

$(document).ready(function() {
  $("#form-resposta").submit(function(event) {
    event.preventDefault();
    const h4 = document.querySelector('h4.informacoes-questao');
    const numero = h4.textContent.match(/\d+/)[0];
    var respostaSelecionada = $('input[name="alternativa"]:checked');
    var respostaSelecionadaValor = respostaSelecionada.val();
    var questionId = numero;
	</script>
	<script>

    $.ajax({
      url: "verificar_resposta.php",
      type: "post",
      data: {
        alternativa: respostaSelecionadaValor,
        question_id: questionId
      },
      success: function(data) {
        $("#resultado-verificacao").html(data);
        respostaSelecionada.closest('.alternativa').find('.alternativa-letra').addClass('alternativa-selecionada');
      }
    });
  });
});

</script>

<body>
	<form>
		<label>
			<input type="radio" name="alternativa" value="a">
			<span class="alternativa-letra">A</span>
		</label>

		<label>
			<input type="radio" name="alternativa" value="b">
			<span class="alternativa-letra">B</span>
		</label>

	</form>

	<script>
		$('input[name="alternativa"]').on('change', function() {
			// Remove a classe .alternativa-selecionada de todas as alternativas
			$('.alternativa-letra').removeClass('alternativa-selecionada');

			// Adiciona a classe .alternativa-selecionada apenas na alternativa selecionada
			$(this).parent('label').find('.alternativa-letra').addClass('alternativa-selecionada');
		});
	</script>

</body>

</html>