# Simple Code

Micro Framework em php

## Configuração

Ativar o modo de reescrita de url no apache, exemplo no ubuntu:

https://www.digitalocean.com/community/tutorials/how-to-rewrite-urls-with-mod_rewrite-for-apache-on-ubuntu-18-04

Criar um arquivo htaccess na raiz do projeto com seguinte conteudo :
```
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?/$1 [L]
```
Se o projeto não estiver na raiz do servidor expecificar o diretorio pela variavel RewriteBase:
```
RewriteEngine on
RewriteBase /diretorio-projeto/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?/$1 [L]
```
No arquivo System/Constant.php configurar o dominio em que o projeto esta sendo executado :

```
const BASE_URL = 'http://localhost/simple-code'; /* http://www.seuprojeto.com.br */
```



