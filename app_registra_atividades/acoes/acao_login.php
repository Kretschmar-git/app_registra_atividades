<?php
session_start();
require_once "../includes/db.php";

$_SESSION['usuario'] = $_POST["nome_usuario"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_usuario = trim($_POST["nome_usuario"]);
    $senha = trim($_POST["senha"]);

    $sql = "SELECT id, nome_usuario, senha FROM usuarios WHERE nome_usuario = ?";

    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param("s", $nome_usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $nome_usuario, $senha_hash);
            if ($stmt->fetch()) {
                if (password_verify($senha, $senha_hash)) {
                    // Senha correta, inicia a sessão
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["nome_usuario"] = $nome_usuario;

                    header("location: ../dashboard.php");
                } else {
                    // Senha incorreta
                    echo "A senha que você digitou não é válida.<br>";
                    echo "<a href='../login.php'>Voltar para o login.</a><br>";
                }
            }
        } else {
            echo "Nenhuma conta encontrada com esse nome de usuário.<br>";
            echo "<a href='../login.php'>Voltar para o login.</a><br>";
        }
        
    }
    
}
