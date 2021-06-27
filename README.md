# Baú de História

Por André Murgo Piva - 126956410

andrempiva arroba gmail ponto com

## Orientações de como colocar o site no ar

* Fazer uma cópia do arquivo `.env.example` com o nome `.env`
* Criar um banco de dados  **mysql** ou **pgsql** e um usuário com acesso a ele
* Configurar o acesso ao banco de dados nas seguintes linhas do arquivo `.env`. Exemplo:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=baudehistorias
DB_USERNAME=padmin
DB_PASSWORD=secret
```

* Rodar os seguintes comandos

```
composer install
npm install
npm prod
php artisan key:generate
php artisan storage:link
```


Então é só rodar o comando `php artisan serve` que o ele hosteia o site no ip, ou configurar nginx ou apache para usar a pasta raíz do site.

........
