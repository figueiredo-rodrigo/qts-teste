<button id="marca-texto">Marcar texto</button>



	<script>
		const btnMarcaTexto = document.getElementById('marca-texto');

		btnMarcaTexto.addEventListener('click', () => {
			const trechoSelecionado = window.getSelection().toString();
			if (trechoSelecionado) {
				const marcacao = document.createElement('span');
				marcacao.className = 'marca';
				marcacao.textContent = trechoSelecionado;
				const range = window.getSelection().getRangeAt(0);
				range.surroundContents(marcacao);
			}
		});
	</script>

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