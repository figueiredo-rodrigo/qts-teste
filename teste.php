<form method="get" action="pagina_resultados.php">
  <label for="categoria">Filtrar por categoria:</label>
  <select name="categoria" id="categoria">
    <option value="">Todos</option>
    <option value="eletronicos">Eletrônicos</option>
    <option value="roupas">Roupas</option>
    <option value="alimentos">Alimentos</option>
  </select>
  <br>
  <label for="preco_min">Filtrar por preço mínimo:</label>
  <input type="number" name="preco_min" id="preco_min">
  <br>
  <label for="preco_max">Filtrar por preço máximo:</label>
  <input type="number" name="preco_max" id="preco_max">
  <br>
  <input type="submit" value="Filtrar">
</form>
