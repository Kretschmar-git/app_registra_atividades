# Sistema de Gerenciamento de Atividades (To-Do List)

## 📝 Descrição do Projeto

Este é um sistema web completo, desenvolvido em **PHP**, que permite aos usuários gerenciar suas atividades diárias (To-Do List). A aplicação conta com um sistema de autenticação seguro para garantir que cada usuário tenha acesso apenas às suas próprias tarefas. O front-end é construído com **HTML5** e estilizado com **Bootstrap 5**, enquanto o back-end utiliza **PHP** e **MySQL/MariaDB** para persistência de dados.

O projeto foi estruturado para ser modular e de fácil manutenção, separando a lógica de negócios (ações), a interface do usuário (páginas) e os componentes reutilizáveis (includes).

---

## ✨ Funcionalidades Principais

- **Autenticação de Usuários**:
  - Página de Cadastro de novos usuários com validação de dados.
  - Página de Login segura com verificação de senha hasheada (`password_verify`).
  - Funcionalidade de Logout para encerrar a sessão do usuário.
  - Página de Perfil para alteração de senha.
- **Gerenciamento de Atividades (CRUD)**:
  - **Criar**: Adicionar novas atividades através de um formulário em modal.
  - **Ler**: Listar todas as atividades do usuário logado em uma tabela dinâmica.
  - **Atualizar**: Editar o título, a descrição e o status (pendente/concluída) de uma atividade existente.
  - **Deletar**: Remover atividades que não são mais necessárias.
- **Segurança**:
  - As senhas são armazenadas de forma segura no banco de dados usando `password_hash`.
  - O acesso às páginas internas e às operações de CRUD é protegido, garantindo que apenas usuários autenticados possam interagir com o sistema.
  - As consultas ao banco de dados são feitas com _Prepared Statements_ para prevenir injeção de SQL.

---

## 🛠️ Tecnologias Utilizadas

- **Back-end**: PHP 7.4+
- **Front-end**: HTML5, Bootstrap 5, JavaScript (AJAX)
- **Banco de Dados**: MySQL / MariaDB

---

## 📂 Estrutura de Arquivos

A estrutura do projeto foi organizada da seguinte forma:
```
/ (Diretório Raiz)<br>
|<br>
|--- acoes/<br>
| |-- acao_cadastro.php (Processa o formulário de registro de novos usuários)<br>
| |-- acao_login.php (Processa o formulário de login e autenticação)<br>
| |-- acao_logout.php (Finaliza a sessão do usuário)<br>
| |-- acao_perfil.php (Processa a alteração de senha do usuário)<br>
| |-- gerenciar_atividades.php (API para criar, ler, atualizar e deletar atividades via AJAX)<br>
|<br>
|--- includes/<br>
| |-- cabecalho.php (Componente reutilizável: cabeçalho HTML, menu, etc.)<br>
| |-- rodape.php (Componente reutilizável: rodapé HTML, scripts JS, etc.)<br>
| |-- db.php (Arquivo de configuração da conexão com o banco de dados)<br>
|<br>
|--- assets/ (sugestão)<br>
| |-- css/<br>
| | |-- style.css (Folha de estilos personalizada)<br>
| |-- js/<br>
| |-- script.js (Arquivo JavaScript com as funções AJAX e manipulação do DOM)<br>
|<br>
|--- index.php (Página inicial / Landing Page para visitantes)<br>
|--- cadastro.php (Página com o formulário de cadastro)<br>
|--- login.php (Página com o formulário de login)<br>
|--- dashboard.php (Painel principal do usuário logado para gerenciar atividades)<br>
|--- perfil.php (Página para o usuário alterar seus dados, como a senha)<br>
|--- README.md (Documentação do projeto)<br>
```
## 🚀 Como Executar o Projeto

1.  **Pré-requisitos**:

    - Um ambiente de servidor local como XAMPP, WAMP ou MAMP.
    - PHP 7.4 ou superior.
    - MySQL ou MariaDB.

2.  **Banco de Dados**:

    - Crie um banco de dados (ex: `meu_projeto_db`).
    - Importe o seguinte script SQL para criar as tabelas `usuarios` e `atividades`:

    ```sql
    CREATE TABLE usuarios (
      id INT AUTO_INCREMENT PRIMARY KEY,
      nome_usuario VARCHAR(50) NOT NULL UNIQUE,
      senha VARCHAR(255) NOT NULL,
      data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE atividades (
      id INT AUTO_INCREMENT PRIMARY KEY,
      usuario_id INT NOT NULL,
      titulo VARCHAR(100) NOT NULL,
      descricao TEXT,
      status ENUM('pendente', 'concluida') DEFAULT 'pendente',
      data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
    );
    ```

3.  **Configuração**:

    - Clone ou baixe este repositório para a pasta `htdocs` (ou `www`) do seu servidor local.
    - Abra o arquivo `includes/db.php` e configure as credenciais de conexão com o seu banco de dados.

4.  **Execução**:
    - Inicie seu servidor Apache e MySQL.
    - Abra o navegador e acesse `http://localhost/nome_da_pasta_do_projeto/`.

---

## 🎯 Como Usar a Aplicação

1.  **Cadastro**: Acesse a página principal e clique em "Começar Agora" para criar uma nova conta.
2.  **Login**: Após o cadastro, faça login com seu nome de usuário e senha.
3.  **Dashboard**: Você será redirecionado para o dashboard, onde poderá ver suas atividades.
4.  **Gerenciar Atividades**:
    - Clique em "+ Nova Atividade" para abrir o modal e adicionar uma tarefa.
    - Use os botões de editar (✏️) e deletar (🗑️) em cada linha para gerenciar suas atividades.
5.  **Perfil e Logout**: Use os links na barra de navegação para alterar sua senha ou sair do sistema.
