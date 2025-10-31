<?php require_once "./includes/cabecalho.php"; ?>

<?php
$usuario2 = isset($_SESSION['usuarioo']) ? $_SESSION['usuarioo'] : '';
?>

<div class="container mt-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Crie sua Conta</h3>
                </div>
                <div class="card-body">
                    <form action="acoes/acao_cadastro.php" method="post">
                        <div class="mb-3">
                            <label for="nome_usuario" class="form-label">Nome de Usuário</label>
                            <input type="text" class="form-control" id="nome_usuario" name="nome_usuarioo" value="<?php echo $usuario2 ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirma_senha" class="form-label">Confirme a Senha</label>
                            <input type="password" class="form-control" id="confirma_senha" name="confirma_senha" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p>Já tem uma conta? <a href="login.php">Faça login aqui</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "./includes/rodape.php"; ?>