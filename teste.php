<!DOCTYPE html>
<html>
<head>
	<title>Exemplo de mudança de cor com botões de rádio</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<style>
		.alternativa-letra {
			font-size: 24px;
			font-weight: bold;
			display: inline-block;
			padding: 8px;
			margin-right: 8px;
			border: 1px solid #ccc;
			border-radius: 50%;
			cursor: pointer;
			color: #333;
		}

		.alternativa-selecionada {
			background-color: #ffcc00;
			color: #fff;
			border-color: #ffcc00;
		}
	</style>
</head>
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

		<label>
			<input type="radio" name="alternativa" value="c">
			<span class="alternativa-letra">C</span>
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
