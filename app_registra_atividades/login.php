<?php require_once "./includes/cabecalho.php"; ?>
<?php
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
?>

<div class="container mt-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Faça seu login</h3>
                </div>
                <div class="card-body">
                    <form action="acoes/acao_login.php" method="post">
                        <div class="mb-3">
                            <label for="nome_usuario" class="form-label">Nome de Usuário</label>
                            <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" value="<?php echo $usuario ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "./includes/rodape.php"; ?>