document.addEventListener('DOMContentLoaded', function () {
    // Carrega a lista de atividades assim que a página do dashboard for carregada
    if (document.getElementById('tabela-atividades')) {
        listarAtividades();
    }
});

function listarAtividades() {
    fetch('acoes/crud_atividades.php?acao=listar')
        .then(response => response.text())
        .then(data => {
            document.getElementById('tabela-atividades').innerHTML = data;
        })
        .catch(error => console.error('Erro ao listar atividades:', error));
}

function salvarAtividade() {
    const form = document.getElementById('form-atividade');
    const formData = new FormData(form);
    formData.append('acao', 'salvar');

    fetch('acoes/crud_atividades.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Fecha o modal
                const modalElement = document.getElementById('addAtividadeModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                } else {
                    new bootstrap.Modal(modalElement).hide();
                }

                // Limpa o formulário e recarrega a lista
                form.reset();
                document.getElementById('atividade_id').value = '';
                listarAtividades();
            } else {
                alert('Erro: ' + data.message);
            }
        })
        .catch(error => console.error('Erro ao salvar atividade:', error));
}

function editarAtividade(id) {
    fetch(`acoes/crud_atividades.php?acao=buscar_um&id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('atividade_id').value = data.id;
            document.getElementById('titulo').value = data.titulo;
            document.getElementById('descricao').value = data.descricao;
            document.getElementById('status').value = data.status;

            document.getElementById('modalLabel').textContent = 'Editar Atividade';

            const modal = new bootstrap.Modal(document.getElementById('addAtividadeModal'));
            modal.show();
        })
        .catch(error => console.error('Erro ao buscar atividade:', error));
}

function deletarAtividade(id) {
    if (confirm('Tem certeza que deseja deletar esta atividade?')) {
        const formData = new FormData();
        formData.append('acao', 'deletar');
        formData.append('id', id);

        fetch('acoes/crud_atividades.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    listarAtividades();
                } else {
                    alert('Erro: ' + data.message);
                }
            })
            .catch(error => console.error('Erro ao deletar atividade:', error));
    }
}

// Limpa o modal quando ele é fechado para garantir que o formulário esteja limpo para uma nova adição
const addModal = document.getElementById('addAtividadeModal');
if (addModal) {
    addModal.addEventListener('hidden.bs.modal', function () {
        document.getElementById('form-atividade').reset();
        document.getElementById('atividade_id').value = '';
        document.getElementById('modalLabel').textContent = 'Adicionar Nova Atividade';
    });
}