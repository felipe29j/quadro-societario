# Quadro Societario - Sistema de Cadastro

Este é um projeto de sistema para cadastro de empresas e seu quadro societário, desenvolvido com Symfony no backend e Angular no frontend. O projeto inclui funcionalidades para CRUD de empresas e sócios, autenticação.

### Configuração do Backend (Symfony)

## 1.Clonar o Repositório

git clone https://github.com/felipe29j/quadro-societario.git

   cd empresa-socio

## 2. Instalar Dependências

    composer install

## 3. Configurar Banco de Dados 

    Edite o arquivo .env e configure a URL do banco de dados PostgreSQL:
    username e password
    DATABASE_URL="pgsql://username:password@localhost:5432/quadro_societario"

## 4. Criar a Base de Dados

    php bin/console doctrine:database:create


## 5. Executar Migrações

    php bin/console make:migration
    
    php bin/console doctrine:migrations:migrate


## 6. Iniciar o Servidor

    symfony serve

### Estrutura Básica do Projeto:

## Entidades:

Empresa: Representa a empresa, com atributos como nome, CNPJ, endereço, etc.
Sócio: Representa o sócio, com atributos como nome, CPF, e relação com a empresa.
Funcionalidades CRUD:

## Empresas:
Listar todas as empresas cadastradas.
Visualizar detalhes de uma empresa específica.
Criar uma nova empresa.
Editar uma empresa existente.
Excluir uma empresa.
## Sócios:
Listar todos os sócios cadastrados.
Visualizar detalhes de um sócio específico.
Criar um novo sócio.
Editar um sócio existente.
Excluir um sócio.

### Conclusão

Parabéns! Você concluiu a instalação do projeto de quadro societario. 