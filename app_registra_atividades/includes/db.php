<?php
// Configurações do Banco de Dados
define("DB_SERVER", "localhost");
define("DB_USERNAME", "root"); // Seu usuário do MySQL
define("DB_PASSWORD", "");     // Sua senha do MySQL
define("DB_NAME", "db_atividades");

// Tenta conectar ao banco de dados MySQL
$conexao = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Checa a conexão
if ($conexao->connect_error) {
    die("Erro: Não foi possível conectar. " . $conexao->connect_error);
}

// Garante que o charset seja UTF-8
$conexao->set_charset("utf8mb4");
