
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

### Gerenciamento do Ciclo de Vida dos Contêineres no Docker

No contexto do Docker, o ciclo de vida dos contêineres inclui operações de criação, execução, parada e remoção de contêineres e volumes. O Laravel Sail facilita a gestão desses contêineres e volumes para o projeto, e os comandos a seguir são essenciais para garantir que o ambiente seja limpo e recriado quando necessário.

#### Comandos de Controle do Ciclo de Vida

1. **Remover Contêineres e Volumes**: 

   ```bash
   ./vendor/bin/sail down -v
   ```

   Esse comando encerra todos os contêineres em execução e remove as redes e volumes associados ao projeto. A opção `-v` é especialmente útil para resolver problemas de cache e inconsistências, pois força a remoção dos volumes de dados que mantêm informações persistentes do projeto.

2. **Iniciar Contêineres e Recriar Volumes**:

   ```bash
   ./vendor/bin/sail up -d
   ```

   Esse comando reinicia o ambiente do Docker em "modo desligado" (`-d`), o que significa que os contêineres são executados em segundo plano. Ele recria todos os contêineres e volumes necessários de acordo com as definições no arquivo `docker-compose.yml`, garantindo que a configuração e o armazenamento do projeto estejam limpos e atualizados.

Esses comandos são recomendados quando você enfrenta problemas de inconsistência ou precisa garantir que o ambiente do Docker esteja na configuração padrão, pois eles eliminam qualquer cache ou dado antigo que possa interferir no funcionamento do projeto.
