# Aplicação de Gerenciamento de Clientes

## Requisitos

1. PHP 8.2
2. MySQL

## Configuração

1. Clone o repositório.
2. Crie um arquivo `.env` na raiz do projeto com base no arquivo `.env.example`. 
3. Configure o banco de dados e outras variáveis de ambiente no arquivo `.env` ou diretamente no arquivo config/config.php.
4. Crie o banco de dados e as tabelas necessárias usando o script `db.sql`.
5. Um usuário padrão será criado ao acessar a home da aplicação:
   - Email: `admin@admin.com`
   - Senha: `admin123`
6. Configure o servidor web (xampp) para apontar para a pasta `kabum`.

## Executando a Aplicação

1. Acesse a aplicação através da URL base `/kabum`.

## Testes

1. Execute os testes com PHPUnit (phpunit --testdox).

## Estrutura do Projeto

- `config`: Configurações do banco de dados.
- `controllers`: Controladores da aplicação.
- `models`: Modelos de dados.
- `views`: Views da aplicação.
- `routes`: Arquivo de roteamento.
- `tests`: Testes automatizados.
- `public`: Pasta destinada a JavaScript e CSS da aplicação.
- `utils`: Utilitários diversos.
