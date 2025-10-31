<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    exit("Acesso negado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $confirma_nova_senha = $_POST['confirma_nova_senha'];

    if ($nova_senha != $confirma_nova_senha) {
        die("Erro: As novas senhas não coincidem.");
    }

    $usuario_id = $_SESSION['id'];

    // Buscar a senha atual no banco de dados
    $sql = "SELECT senha FROM usuarios WHERE id = ?";
    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $stmt->bind_result($senha_hash_db);
        $stmt->fetch();
        $stmt->close();

        // Verificar se a senha atual está correta
        if (password_verify($senha_atual, $senha_hash_db)) {
            // Se estiver correta, hashear a nova senha e atualizar
            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $sql_update = "UPDATE usuarios SET senha = ? WHERE id = ?";

            if ($stmt_update = $conexao->prepare($sql_update)) {
                $stmt_update->bind_param("si", $nova_senha_hash, $usuario_id);
                if ($stmt_update->execute()) {
                    echo "Senha alterada com sucesso!";
                    // O ideal é redirecionar após um tempo
                    header("refresh:2;url=../dashboard.php");
                } else {
                    echo "Erro ao atualizar a senha.";
                }
                $stmt_update->close();
            }
        } else {
            echo "Erro: A senha atual está incorreta.";
            die("<a href='../perfil.php'>Voltar para o perfil.</a><br>");
        }
    }
    $conexao->close();
}
