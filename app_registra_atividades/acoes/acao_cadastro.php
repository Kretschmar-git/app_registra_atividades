<?php
require_once "../includes/db.php";

session_start();

$_SESSION['usuarioo'] = $_POST["nome_usuarioo"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_usuario = trim($_POST["nome_usuarioo"]);
    $senha = trim($_POST["senha"]);
    $confirma_senha = trim($_POST["confirma_senha"]);

    // Validações
    if (empty($nome_usuario) || empty($senha) || empty($confirma_senha)) {
        echo "Erro: Por favor, preencha todos os campos.<br>";
        die("<a href='../cadastro.php'>Voltar para o cadastro.</a><br>");
    }
    if ($senha != $confirma_senha) {
        echo "Erro: As senhas não coincidem.<br>";
        die("<a href='../cadastro.php'>Voltar para o cadastro.</a><br>");
    }

    // Verifica se usuário já existe
    $sql = "SELECT id FROM usuarios WHERE nome_usuario = ?";
    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param("s", $nome_usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            echo "Erro: Este nome de usuário já está em uso.<br>";
            die("<a href='../cadastro.php'>Voltar para o cadastro.</a><br>");
        }
        $stmt->close();
    }

    // Insere novo usuário com senha hasheada
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nome_usuario, senha) VALUES (?, ?)";

    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param("ss", $nome_usuario, $senha_hash);

        if ($stmt->execute()) {
            header("location: ../login.php");
            exit();
        } else {
            echo "Algo deu errado. Por favor, tente novamente mais tarde.<br>";
            echo "<a href='../cadastro.php'>Voltar para o cadastro.</a><br>";
        }
        $stmt->close();
    }

    $conexao->close();
}
