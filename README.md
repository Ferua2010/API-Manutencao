# API para Controle de Chamados de Manutenção

API simples em PHP que gerencia chamados de manutenção de equipamentos via requisições HTTP com JSON.

## Requisitos

- PHP 7+
- PDO
- Banco de dados MySQL

## Instalação

### 1. Crie o banco de dados

```sql
CREATE DATABASE manutencao;
USE manutencao;
```

### 2. Crie a tabela chamados

```sql
CREATE TABLE chamados (
    id INT PRIMARY KEY AUTO_INCREMENT,
    equipamento VARCHAR(100),
    setor VARCHAR(100),
    descricao TEXT,
    prioridade VARCHAR(20),
    status VARCHAR(20)
);
```

### 3. Configure o arquivo conexao.php

Edite o arquivo `conexao.php` com os dados de acesso ao seu banco de dados MySQL (host, usuário, senha e nome do banco).

## Estrutura do Projeto

```
projeto-chamados/
├── chamados.php       # Arquivo principal da API
└── conexao.php        # Conexão com o banco de dados
```

## Endpoints

Todos os endpoints utilizam a URL: `/api/chamados.php`

### POST – Cadastrar chamado

**Método:** `POST`  
**Content-Type:** `application/json`

**Corpo da requisição:**

```json
{
  "equipamento": "Ar Condicionado",
  "setor": "Recepção",
  "descricao": "Não está gelando",
  "prioridade": "alta",
  "status": "aberto"
}
```

**Valores válidos:**

- `prioridade`: `baixa`, `media`, `alta`
- `status`: `aberto`, `em andamento`, `concluido`

**Resposta de sucesso:**

```json
{
  "Mensagem": "Chamado realizado com sucesso!"
}
```

---

### GET – Listar chamados

**Método:** `GET`

**Resposta:**

```json
[
  {
    "id": 1,
    "equipamento": "Ar Condicionado",
    "setor": "Recepção",
    "descricao": "Não está gelando",
    "prioridade": "alta",
    "status": "aberto"
  }
]
```

---

### PUT – Atualizar chamado

**Método:** `PUT`  
**Content-Type:** `application/json`

**Corpo da requisição:**

```json
{
  "id": 1,
  "equipamento": "Ar Condicionado",
  "setor": "Recepção",
  "descricao": "Não está gelando",
  "prioridade": "media",
  "status": "em andamento"
}
```

**Resposta de sucesso:**

```json
{
  "Mensagem": "Chamado atualizado com sucesso!"
}
```

---

### DELETE – Excluir chamado

**Método:** `DELETE`  
**Content-Type:** `application/json`

**Corpo da requisição:**

```json
{
  "id": 1
}
```

**Resposta de sucesso:**

```json
{
  "Mensagem": "Produto excluído com sucesso!"
}
```

---

## Regras de Negócio

- A prioridade deve aceitar apenas: `baixa`, `media` ou `alta`.
- O status deve aceitar apenas: `aberto`, `em andamento` ou `concluido`.
- Antes de executar uma operação, o sistema verifica se os dados obrigatórios foram informados.
- Todas as respostas são retornadas em formato JSON.

## Exemplos de Uso

### Cadastrando um chamado (usando cURL)

```bash
curl -X POST http://localhost/api/chamados.php   -H "Content-Type: application/json"   -d '{
    "equipamento": "Ar Condicionado",
    "setor": "Recepção",
    "descricao": "Não está gelando",
    "prioridade": "alta",
    "status": "aberto"
  }'
```

### Listando todos os chamados

```bash
curl -X GET http://localhost/api/chamados.php
```

### Atualizando um chamado

```bash
curl -X PUT http://localhost/api/chamados.php   -H "Content-Type: application/json"   -d '{
    "id": 1,
    "equipamento": "Ar Condicionado",
    "setor": "Recepção",
    "descricao": "Não está gelando",
    "prioridade": "media",
    "status": "em andamento"
  }'
```

### Excluindo um chamado

```bash
curl -X DELETE http://localhost/api/chamados.php   -H "Content-Type: application/json"   -d '{"id": 1}'
```

## Observações

- A API valida prioridade e status antes de executar as operações.
- Todas as respostas são retornadas em formato JSON.
- Utiliza PDO para acesso seguro ao banco de dados.