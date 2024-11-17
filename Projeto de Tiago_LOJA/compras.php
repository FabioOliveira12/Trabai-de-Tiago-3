<?php
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar_compra'])) {
    $id_produto = $_POST['id_produto'];
    $id_cliente = $_POST['id_cliente'];
    $quantidade = $_POST['quantidade'];

    // Obter o preço do produto
    $sql_produto = "SELECT preco FROM produtos WHERE id = :id_produto";
    $stmt_produto = $conn->prepare($sql_produto);
    $stmt_produto->bindParam(':id_produto', $id_produto);
    $stmt_produto->execute();
    $produto = $stmt_produto->fetch(PDO::FETCH_ASSOC);
    
    // Calcular o valor total da compra
    $valor_total = $produto['preco'] * $quantidade;

    // Inserir compra
    $sql = "INSERT INTO compras (id_produto, id_cliente, quantidade, valor_total) 
            VALUES (:id_produto, :id_cliente, :quantidade, :valor_total)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_produto', $id_produto);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->bindParam(':quantidade', $quantidade);
    $stmt->bindParam(':valor_total', $valor_total);

    if ($stmt->execute()) {
        $mensagem = "Compra realizada com sucesso!";
    } else {
        $mensagem = "Erro ao realizar a compra.";
    }
}

$sql = "SELECT c.id, p.nome AS produto_nome, cl.nome AS cliente_nome, c.quantidade, c.valor_total 
        FROM compras c
        JOIN produtos p ON c.id_produto = p.id
        JOIN clientes cl ON c.id_cliente = cl.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">   
   
    
</head>
<body>
    <header>
        <hgroup class="box-titulo">
            <h1><a href="index.php">Loja</a></h1>
        </hgroup>
        <nav>
            <a href="index.php"><i class="fas fa-home"></i> Inicio</a>
            <a href="estoque.php"><i class="fas fa-box"></i> Estoque</a>
            <a href="produtos.php"><i class="fas fa-tag"></i> Produto</a>
            <a href="fornecedores.php"><i class="fas fa-truck"></i> Fornecedor</a>
            <a href="clientes.php"><i class="fas fa-user"></i> Cliente</a>
            <a href="compras.php"><i class="fas fa-shopping-cart"></i> Compra</a>
        </nav>
    </header>
    <main>
    
    <h1>Gestão de Compras</h1>
    <form action="compras.php" method="POST">
        <label for="id_produto">Produto:</label>
        <select name="id_produto" required>
            <?php
            $produtos = $conn->query("SELECT id, nome FROM produtos");
            while ($produto = $produtos->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $produto['id'] . "'>" . $produto['nome'] . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="id_cliente">Cliente:</label>
        <select name="id_cliente" required>
            <?php
            $clientes = $conn->query("SELECT id, nome FROM clientes");
            while ($cliente = $clientes->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $cliente['id'] . "'>" . $cliente['nome'] . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" required>
        <br>
        <button type="submit" name="adicionar_compra">Realizar Compra</button>
    </form>
<div id="mensagem" class="mensagem">
    <?php if (isset($mensagem)) echo "<p>$mensagem</p>"; ?>
</div>
    <h3>Lista de Compras</h3>
    <table class="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Cliente</th>
                <th>Quantidade</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['produto_nome']) ?></td>
                    <td><?= htmlspecialchars($row['cliente_nome']) ?></td>
                    <td><?= htmlspecialchars($row['quantidade']) ?></td>
                    <td>R$<?= htmlspecialchars($row['valor_total']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </main>
    <footer>
        <p class="credits">&COPY;2024 Todos os direitos reservados! Fábio Oliveira</p>
    </footer>
</body>
</html>
