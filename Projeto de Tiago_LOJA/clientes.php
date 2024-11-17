<?php
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar_cliente'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];

    $sql = "INSERT INTO clientes (nome, email, telefone, cpf) VALUES (:nome, :email, :telefone, :cpf)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':cpf', $cpf);
    if ($stmt->execute()) {
        $mensagem = "Cliente adicionado com sucesso!";
    } else {
        $mensagem = "Erro ao adicionar cliente.";
    }
}

$sql = "SELECT * FROM clientes";
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
    <h1 class="client">Gestão de Clientes</h1>
    <form action="clientes.php" method="POST">
        <input type="text" name="nome" placeholder="Nome do Cliente" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="telefone" placeholder="Telefone" required>
        <input type="text" name="cpf" placeholder="Cpf" required>
        <button type="submit" name="adicionar_cliente">Adicionar Cliente</button>
    </form>
<div id="mensagem" class="mensagem">
    <?php if (isset($mensagem)) echo "<p>$mensagem</p>"; ?>
</div>
    <h3>Lista de Clientes</h3>
    <table class="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Cpf</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['telefone']) ?></td>
                    <td><?= htmlspecialchars($row['cpf']) ?></td>
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
