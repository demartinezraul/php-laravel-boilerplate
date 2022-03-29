# Boilerplate laravel + DDD + docker + swagger

Boilerplate laravel + DDD + docker + swagger.

## Tecnologias Utilizadas

- [Docker](https://www.docker.com/)
- [PHP 8](https://www.php.net/releases/8.0/en.php)
- [MYSQL 5.7](https://www.mysql.com/downloads/)
- [Laravel 8](https://laravel.com/docs/8.x/releases)

## Montagem de Ambiente

Para Windows:

Habilite o HyperV no windows.

Instale e execute o [Docker For Desktop](https://download.docker.com/win/stable/Docker%20Desktop%20Installer.exe)

Para Linux:

Instale o docker: [Deste Link](https://docs.docker.com/engine/install/ubuntu)

## Próximos Passoss

Abra a linha de comando e através dela navegue até a pasta do projeto.

Na pasta raiz, execute o comando:

```bash
docker-compose up -d
```

Abra o arquivo .env e altere as variáveis abaixo com os valores descritos:

```bash
APP_URL=http://localhost:5000

DB_HOST=api-financeiro-db
DB_PORT=3306
DB_DATABASE=financeiro
DB_USERNAME=root    
DB_PASSWORD=root
DB_ROOT_PASSWORD=root

REDIS_HOST=api-financeiro-redis
REDIS_PASSWORD=
REDIS_PORT=6379
REDIS_QUEUE=cache

L5_SWAGGER_GENERATE_ALWAYS=true
L5_SWAGGER_BASE_PATH=
L5_SWAGGER_UI_ASSETS_PATH=
L5_SWAGGER_GENERATE_YAML_COPY=
L5_SWAGGER_OPERATIONS_SORT=

XDEBUG_CONFIG="remote_host=host.docker.internal remote_port=9001 remote_enable=1 remote_autostart=1 xdebug.idekey=VSCODE"
HOST_SERVER_NAME=localhost

```

Entre no conteiner executando o seguinte comando

```bash
docker exec -it box-app bash
```

É necessario criar um Personal Access Token no Gitlab para fazer a autenticação 
Vá na sua conta do Gitlab, clique em `profile`, clique em `preferencies` e após clique em `Personal Access Token`.

Abra o seu terminal e digite.

`composer config gitlab-token.gitlab.boxdelivery.com.br COLE_SEU_PERSONAL_ACCESS_TOKEN`

Execute (opcional)4:

`composer config gitlab-domains gitlab.boxdelivery.com.br`

Execute o arquivo `larascripts.sh`:

```bash
./larascripts.sh
```

Ou, se preferir execute os comandos passo a passo:

Instale as dependências do projeto

```bash
composer install
```

Execute oos comandos a seguir para confirmar as alterações no arquivo .env

```bash
php artisan optimize && php artisan config:clear
```

Execute os comandos abaixo para garantir que a aplicação tenha permissão para manipular arquivos

```bash
chmod -R guo+w storage && php artisan cache:clear
```

Defina o banco de dados a ser utilizado pela aplicação conteinerizada (Digite a senha do banco de dados )

```bash
mysql -u root -h box-db -p box
use box;
quit;
```

Obs: Caso o comando ``exit`` não funcione, pressione CTRL+C para voltar para o bash do conteiner.

Realize o dump do banco de dados através do SGBD e execute os scripts necessários.

Acesse a aplicação em [http://localhost:5000](http://localhost:5000)

Para parar a execução do conteiner execute ``docker stop NOME_DO_CONTEINER``

Caso seja necessário remover todos os conteiners e recriá-los por conta de algum erro ou problema, execute os seguintes comandos:

```bash
docker-compose down; 
docker stop $(docker ps -a -q); 

docker system prune; docker volume prune; 
docker container prune; 
docker images prune; 
docker builder prune; 

docker rm -f $(docker ps -a -q); 
docker rmi -f $(docker images -a -q); 
docker kill $(docker ps -q);
```

Caso o container já exista e seja necessário recompilá-lo execute

```bash
docker-compose up -d --force-recreate
```

Abaixo seguem alguns comandos úteis

Reiniciar o container

```bash
docker-compose restart
```
Reiniciar o container

Para execução do container

```bash
docker-compose start
```

Observação: Para evitar a perda dos dados do banco o conteiner não deve ser derrubado usando o comando ``docker-compose down``, é recomendado que seja utilizado o ``docker stop NOME_DO_CONTEINER`` ou que os conteineres permaneçam ativos.

### Debugando com XDebug

Para facilitar o processo de depuração da aplicação você terá que configurar sua IDE ou Editor de Código para permitir a depuração remota.

#### VSCODE

Instale a extensão [PHP Debug](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug) em seu Visual Studio Code

E coloque o trecho de código abaixo no arquivo `launch.json` localizado na pasta `.vscode` do projeto.

```bash
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen XDebug for Docker",
            "type": "php",
            "request": "launch",
            "port": 9001,
            "pathMappings": {
                "/app": "${workspaceFolder}"
            },
            "xdebugSettings": {
                "max_data": 65535,
                "show_hidden": 1,
                "max_children": 100,
                "max_depth": 5
            }
        }
    ]
}
```

Reinicie os conteineres usando `docker restart $(docker ps -aq)`

Vá até o VSCODE, defina o breakpoint na linha desejada e inicie o XDebug, em seguida, vá até a seção `Breakpoints` e desmarque a opção `Everything`.

Caso ocorra algum erro durante a execução do debugger desmarque também a opção `Exceptions`.
