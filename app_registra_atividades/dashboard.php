<?php
require_once "./includes/cabecalho.php";

// Proteção de página: redireciona se não estiver logado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "./includes/db.php";
$usuario_id = $_SESSION['id'];
?>

<div class="container mt-5 flex-grow-1">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Minhas Atividades</h2>

            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAtividadeModal">
                <i class="fas fa-plus"></i> Nova Atividade
            </button>

            <div id="tabela-atividades" class="table-responsive">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addAtividadeModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Adicionar Nova Atividade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-atividade">
                    <input type="hidden" id="atividade_id" name="id">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="pendente">Pendente</option>
                            <option value="concluida">Concluída</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="salvarAtividade()">Salvar</button>
            </div>
        </div>
    </div>
</div>


<?php require_once "./includes/rodape.php"; ?>