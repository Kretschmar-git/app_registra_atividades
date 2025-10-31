<?php
// Inicia a sessão em todas as páginas que usarem o header
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Atividades Diárias</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="./assets/css/estilo.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-check-circle"></i> Atividades Diárias</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Minhas Atividades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="perfil.php" style="color: green;">Olá, <?php echo htmlspecialchars($_SESSION["nome_usuario"]); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="acoes/acao_logout.php" style="color: red;">Sair <i class="fas fa-sign-out-alt"></i></a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="cadastro.php">Cadastre-se</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>