-- Script de criação do banco de dados para o sistema de controle de estoque de TI
-- Gerado em 2025-07-17 12:30:30

CREATE DATABASE IF NOT EXISTS controle_estoque_ti;
USE controle_estoque_ti;

-- Tabela de perfis de acesso
CREATE TABLE perfis_acesso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

INSERT INTO perfis_acesso (nome) VALUES 
('Administrador'),
('Técnico'),
('Consulta');

-- Tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil_id INT NOT NULL,
    ativo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (perfil_id) REFERENCES perfis_acesso(id)
);

INSERT INTO usuarios (nome, usuario, senha, perfil_id) VALUES 
('Administrador Geral', 'admin', SHA2('admin123', 256), 1);

-- Tabela de categorias
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- Tabela de fornecedores
CREATE TABLE fornecedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL
);

-- Tabela de unidades de medida
CREATE TABLE unidades_medida (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

-- Tabela de secretarias
CREATE TABLE secretarias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL
);

-- Tabela de itens
CREATE TABLE itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_item VARCHAR(50) NOT NULL UNIQUE,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    categoria_id INT,
    marca_modelo VARCHAR(150),
    especificacoes TEXT,
    fornecedor_id INT,
    unidade_medida_id INT,
    codigo_patrimonial VARCHAR(100),
    vida_util_estimada INT,
    observacoes TEXT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id),
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id),
    FOREIGN KEY (unidade_medida_id) REFERENCES unidades_medida(id)
);

-- Tabela de notas fiscais
CREATE TABLE notas_fiscais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(50),
    chave_acesso VARCHAR(100),
    data_emissao DATE,
    fornecedor_id INT,
    processo_licitatorio VARCHAR(100),
    arquivo_anexo VARCHAR(255),
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id)
);

-- Tabela de unidades físicas em estoque
CREATE TABLE estoque_unidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    numero_serie VARCHAR(100),
    numero_lote VARCHAR(100),
    nota_fiscal_id INT,
    data_entrada DATE,
    secretaria_id INT,
    local_armazenamento VARCHAR(100),
    situacao VARCHAR(50),
    status VARCHAR(50),
    destino_atual VARCHAR(100),
    responsavel_atual VARCHAR(100),
    data_ultima_movimentacao DATETIME,
    codigo_barra_gerado VARCHAR(100),
    FOREIGN KEY (item_id) REFERENCES itens(id),
    FOREIGN KEY (nota_fiscal_id) REFERENCES notas_fiscais(id),
    FOREIGN KEY (secretaria_id) REFERENCES secretarias(id)
);

-- Tabela de entradas
CREATE TABLE entradas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    data_entrada DATE,
    origem VARCHAR(100),
    quantidade INT,
    processo_compra VARCHAR(100),
    nota_fiscal VARCHAR(100),
    responsavel_id INT,
    FOREIGN KEY (item_id) REFERENCES itens(id),
    FOREIGN KEY (responsavel_id) REFERENCES usuarios(id)
);

-- Tabela de saídas
CREATE TABLE saidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    data_saida DATE,
    destino_setor_id INT,
    solicitante VARCHAR(100),
    quantidade INT,
    motivo VARCHAR(255),
    responsavel_id INT,
    FOREIGN KEY (item_id) REFERENCES itens(id),
    FOREIGN KEY (destino_setor_id) REFERENCES secretarias(id),
    FOREIGN KEY (responsavel_id) REFERENCES usuarios(id)
);

-- Tabela de anexos
CREATE TABLE anexos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    tipo VARCHAR(50),
    arquivo_path VARCHAR(255),
    FOREIGN KEY (item_id) REFERENCES itens(id)
);

-- Tabela de logs do sistema
CREATE TABLE logs_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    usuario_id INT,
    acao VARCHAR(50),
    modulo VARCHAR(100),
    id_referencia INT,
    descricao TEXT,
    ip VARCHAR(50),
    user_agent TEXT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
