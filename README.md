
# Laravel App Dockerized with Sail

Este projeto é uma aplicação Laravel que pode ser executada em containers Docker utilizando o Laravel Sail. Abaixo estão as instruções para configurar e rodar o projeto.

## Pré-requisitos

- **Docker**: Certifique-se de que o Docker está instalado no seu sistema. Você pode verificar a instalação com o seguinte comando:
  ```bash
  docker --version
  ```
- **Composer**: Instale o Composer para gerenciar as dependências PHP.

## Instalação

No diretório raiz do projeto, execute o seguinte comando para instalar as dependências:

```bash
composer install
```

Este comando irá instalar todas as dependências necessárias para o projeto Laravel.

## Executando o Projeto com Sail

Após instalar as dependências, você pode iniciar o ambiente de desenvolvimento com o Laravel Sail, utilizando o comando:

```bash
./vendor/bin/sail up -d
```

Este comando irá iniciar os containers do Docker em segundo plano.

## Executando as Migrações

Com o ambiente rodando, aplique as migrações para configurar o banco de dados:

```bash
./vendor/bin/sail artisan migrate
```

## Populando o Banco de Dados

Se você quiser popular o banco de dados com dados de teste (seeds), execute:

```bash
./vendor/bin/sail artisan db:seed
```

## Observações

- Certifique-se de que você está no diretório correto do projeto ao executar os comandos.
- Laravel Sail facilita a execução de um ambiente Docker completo, incluindo serviços como banco de dados e servidor web.
- Para parar os containers, utilize o comando:
  ```bash
  ./vendor/bin/sail down
  ```
"# deovitaBack" 
