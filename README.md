# simple-code
micro framework php


::Sistema de Rotas::

Criar um arquivo htaccess na raiz do projeto com seguinte conteudo :

RewriteEngine on

RewriteCond %{REQUEST_FILENAME} !-f

RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule ^(.*)$ index.php?/$1 [L]


Se o projeto não estiver na raiz do servidor expecificar o diretorio pela variavel RewriteBase: 

RewriteEngine on

RewriteBase /diretorio-projeto/

RewriteCond %{REQUEST_FILENAME} !-f

RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule ^(.*)$ index.php?/$1 [L]


clique abaixo para ver o exemplo:
http://i.imgur.com/SgsdtyY.png
