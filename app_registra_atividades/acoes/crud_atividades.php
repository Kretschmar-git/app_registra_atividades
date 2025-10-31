<?php
session_start();
require_once "../includes/db.php";

// Verifica se o usuário está logado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Acesso negado."]);
    exit;
}

$usuario_id = $_SESSION['id'];
$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

switch ($acao) {
    case 'listar':
        $sql = "SELECT id, titulo, descricao, status FROM atividades WHERE usuario_id = ? ORDER BY data_criacao DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $atividades = $result->fetch_all(MYSQLI_ASSOC);

        // Monta a tabela HTML no servidor
        $output = '<table class="table table-striped table-hover">';
        $output .= '<thead><tr><th>Título</th><th>Descrição</th><th>Status</th><th>Ações</th></tr></thead>';
        $output .= '<tbody>';
        if (count($atividades) > 0) {
            foreach ($atividades as $atividade) {
                $status_badge = $atividade['status'] == 'concluida' ? 'bg-success' : 'bg-warning';
                $output .= '<tr>';
                $output .= '<td>' . htmlspecialchars($atividade['titulo']) . '</td>';
                $output .= '<td>' . htmlspecialchars($atividade['descricao']) . '</td>';
                $output .= '<td><span class="badge ' . $status_badge . '">' . ucfirst($atividade['status']) . '</span></td>';
                $output .= '<td>';
                $output .= '<button class="btn btn-sm btn-info me-2" onclick="editarAtividade(' . $atividade['id'] . ')"><i class="fas fa-edit"></i></button>';
                $output .= '<button class="btn btn-sm btn-danger" onclick="deletarAtividade(' . $atividade['id'] . ')"><i class="fas fa-trash"></i></button>';
                $output .= '</td>';
                $output .= '</tr>';
            }
        } else {
            $output .= '<tr><td colspan="4" class="text-center">Nenhuma atividade encontrada.</td></tr>';
        }
        $output .= '</tbody></table>';
        echo $output;

        $stmt->close();
        break;
    case 'salvar':
        $id = $_POST['id'] ?? null;
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $status = $_POST['status'];

        if (empty($id)) { // Criar
            $sql = "INSERT INTO atividades (usuario_id, titulo, descricao, status) VALUES (?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("isss", $usuario_id, $titulo, $descricao, $status);
        } else { // Atualizar
            $sql = "UPDATE atividades SET titulo = ?, descricao = ?, status = ? WHERE id = ? AND usuario_id = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("sssii", $titulo, $descricao, $status, $id, $usuario_id);
        }

        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao salvar atividade."]);
        }
        $stmt->close();
        break;

    case 'buscar_um':
        $id = $_GET['id'];
        $sql = "SELECT id, titulo, descricao, status FROM atividades WHERE id = ? AND usuario_id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ii", $id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $atividade = $result->fetch_assoc();
        echo json_encode($atividade);
        $stmt->close();
        break;

    case 'deletar':
        $id = $_POST['id'];
        $sql = "DELETE FROM atividades WHERE id = ? AND usuario_id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ii", $id, $usuario_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao deletar atividade."]);
        }
        $stmt->close();
        break;

    default:
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Ação inválida."]);
        break;
}

$conexao->close();
