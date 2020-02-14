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



####################################################################################

Etapa 1 - Habilitando o mod_rewrite
Para que o Apache entenda as regras de reescrita, primeiro precisamos ativar mod_rewrite. Ele já está instalado, mas está desativado em uma instalação padrão do Apache. Use o a2enmodcomando para ativar o módulo:

sudo a2enmod rewrite
Isso ativará o módulo ou alertará que o módulo já está ativado. Para efetivar essas alterações, reinicie o Apache.

sudo systemctl restart apache2
mod_rewriteagora está totalmente ativado. Na próxima etapa, configuraremos um .htaccessarquivo que usaremos para definir regras de reescrita para redirecionamentos.

Etapa 2 - Configurando .htaccess
Um .htaccessarquivo nos permite modificar nossas regras de reescrita sem acessar os arquivos de configuração do servidor. Por esse motivo, .htaccessé fundamental para a segurança do seu aplicativo da web. O período que precede o nome do arquivo garante que o arquivo esteja oculto.

Nota: Todas as regras que você pode colocar em um .htaccessarquivo também podem ser colocadas diretamente nos arquivos de configuração do servidor. De fato, a documentação oficial do Apache recomenda o uso de arquivos de configuração do servidor, e não .htaccessporque o Apache os processa mais rapidamente dessa maneira.

No entanto, neste exemplo simples, o aumento de desempenho será desprezível. Além disso, a configuração de regras .htaccessé conveniente, especialmente com vários sites no mesmo servidor. Ele não requer uma reinicialização do servidor para que as alterações tenham efeito e não requer privilégios de root para editar essas regras, simplificando a manutenção e possibilitando alterações com uma conta sem privilégios. Alguns softwares de código aberto populares, como Wordpress e Joomla, geralmente dependem de um .htaccessarquivo para o software modificar e criar regras adicionais sob demanda.

Antes de começar a usar .htaccessarquivos, você precisará configurar e proteger mais algumas configurações.

Por padrão, o Apache proíbe o uso de um .htaccessarquivo para aplicar regras de reescrita; portanto, primeiro você precisa permitir alterações no arquivo. Abra o arquivo de configuração padrão do Apache usando nanoou o seu editor de texto favorito.

sudo nano /etc/apache2/sites-available/000-default.conf
Dentro desse arquivo, você encontrará um <VirtualHost *:80>bloco começando na primeira linha. Dentro desse bloco, adicione o novo bloco a seguir para que seu arquivo de configuração seja o seguinte. Verifique se todos os blocos estão recuados corretamente.

/etc/apache2/sites-available/000-default.conf
<VirtualHost *:80>
    <Directory /var/www/html>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    . . .
</VirtualHost>
Salve e feche o arquivo. Para efetivar essas alterações, reinicie o Apache.

sudo systemctl restart apache2
Agora, crie um .htaccessarquivo na raiz da web.

sudo nano /var/www/html/.htaccess
Adicione esta linha na parte superior do novo arquivo para ativar o mecanismo de reescrita.

/var/www/html/.htaccess
RewriteEngine on
Salve o arquivo e saia.

Agora você tem um .htaccessarquivo operacional que pode ser usado para controlar as regras de roteamento do aplicativo da web. Na próxima etapa, criaremos arquivos de exemplo de site que usaremos para demonstrar regras de reescrita.

Etapa 3 - Configurando regravações de URL
Aqui, configuraremos uma reescrita básica de URL que converte URLs bonitas em caminhos reais para páginas. Especificamente, permitiremos que os usuários acessem , mas exibem uma página chamada .http://your_server_ip/aboutabout.html

Comece criando um arquivo nomeado about.htmlna raiz da web.

sudo nano /var/www/html/about.html
Copie o seguinte código HTML no arquivo, salve e feche-o.

/var/www/html/about.html
<html>
    <head>
        <title>About Us</title>
    </head>
    <body>
        <h1>About Us</h1>
    </body>
</html>
Você pode acessar esta página em , mas observe que, se tentar acessar , verá um erro 404 Não encontrado . Para acessar a página usando , criaremos uma regra de reescrita.http://your_server_ip/about.htmlhttp://your_server_ip/about/about

Todos RewriteRulesseguem este formato:

Estrutura geral RewriteRule
RewriteRule pattern substitution [flags]
RewriteRule especifica a diretiva.
patterné uma expressão regular que corresponde à string desejada do URL, que é o que o visualizador digita no navegador.
substitution é o caminho para a URL real, ou seja, o caminho dos servidores Apache de arquivo.
flags são parâmetros opcionais que podem modificar o funcionamento da regra.
Vamos criar nossa regra de reescrita de URL. Abra o .htaccessarquivo.

sudo nano /var/www/html/.htaccess
Após a primeira linha, adicione o RewriteRulemarcado em vermelho e salve o arquivo.

/var/www/html/.htaccess
RewriteEngine on
RewriteRule ^about$ about.html [NC]
Nesse caso, ^about$é o padrão, about.htmlé a substituição e [NC]é uma bandeira. Nosso exemplo usa alguns caracteres com significado especial:

^indica o início do URL, depois your_server_ip/.
$ indica o fim do URL.
about corresponde à sequência "about".
about.html é o arquivo real que o usuário acessa.
[NC] é uma sinalização que torna a regra insensitiva.
Agora você pode acessar no seu navegador. De fato, com a regra mostrada acima, os seguintes URLs apontarão para :http://your_server_ip/aboutabout.html

http://your_server_ip/about, por causa da definição da regra.
http://your_server_ip/About, porque a regra não diferencia maiúsculas de minúsculas.
http://your_server_ip/about.html, porque o nome do arquivo apropriado original sempre funcionará.
No entanto, o seguinte não funcionará:

http://your_server_ip/about/, porque a regra declara explicitamente que pode não haver mais nada depois about, pois o $caractere aparece depois about.
http://your_server_ip/contact, porque não corresponderá à aboutsequência da regra.
Agora você tem um .htaccessarquivo operacional com uma regra básica que pode modificar e estender às suas necessidades. Nas seções a seguir, mostraremos dois exemplos adicionais de diretivas comumente usadas.

Exemplo 1 - Simplificando cadeias de consulta com RewriteRule
Os aplicativos da Web geralmente usam cadeias de consulta , que são anexadas a uma URL usando um ponto de interrogação ( ?) após o endereço. Parâmetros separados são delimitados usando um e comercial ( &). As cadeias de consulta podem ser usadas para transmitir dados adicionais entre páginas de aplicativos individuais.

Por exemplo, uma página de resultado de pesquisa escrita em PHP pode usar um URL como http://example.com/results.php?item=shirt&season=summer. Neste exemplo, dois parâmetros adicionais são passados ​​para o result.phpscript do aplicativo imaginário :, itemcom o valor shirte seasoncom o valor summer. O aplicativo pode usar as informações da string de consulta para criar a página certa para o visitante.

As regras de reescrita do Apache geralmente são empregadas para simplificar links longos e desagradáveis, como o acima, em URLs amigáveis que são mais fáceis de digitar e interpretar visualmente. Neste exemplo, gostaríamos de simplificar o link acima para se tornar http://example.com/shirt/summer. Os valores do parâmetro shirte summerainda estão no endereço, mas sem a string de consulta e o nome do script.

Aqui está uma regra para implementar isso:

Subestação simples
RewriteRule ^shirt/summer$ results.php?item=shirt&season=summer [QSA]
O shirt/summeré explicitamente correspondido no endereço solicitado e o Apache é instruído a servir results.php?item=shirt&season=summer.

Os [QSA]sinalizadores são comumente usados ​​em regras de reescrita. Eles dizem ao Apache para anexar qualquer string de consulta adicional ao URL exibido, portanto, se o visitante digitar, o servidor responderá . Sem ele, a string de consulta adicional seria descartada.http://example.com/shirt/summer?page=2results.php?item=shirt&season=summer&page=2

Embora esse método atinja o efeito desejado, o nome do item e a temporada são codificados na regra. Isso significa que a regra não funcionará para outros itens, como pants, ou estações, como winter.

Para tornar a regra mais genérica, podemos usar expressões regulares para corresponder a partes do endereço original e usá-las em um padrão de substituição. A regra modificada terá a seguinte aparência:

Subestação simples
RewriteRule ^([A-Za-z0-9]+)/(summer|winter|fall|spring) results.php?item=$1&season=$2 [QSA]
O primeiro grupo de expressões regulares entre parênteses corresponde a uma sequência contendo caracteres alfanuméricos e números como shirtou pantse salva o fragmento correspondente como a $1variável. O segundo grupo rexpression regulares entre parênteses corresponde exatamente summer, winter, fall, ou spring, e da mesma forma poupa o fragmento combinado como $2.

Os fragmentos correspondentes são então usados ​​no URL resultante iteme nas seasonvariáveis ​​em vez de codificados shirte summervalores que usamos anteriormente.

O acima será convertido, por exemplo, http://example.com/pants/summerem http://example.com/results.php?item=pants&season=summer. Este exemplo também é uma prova futura, permitindo que vários itens e temporadas sejam reescritos corretamente usando uma única regra.

Exemplo 2 - Adicionando condições com lógica usando RewriteConds
As regras de reescrita nem sempre são avaliadas uma a uma, sem limitações. A RewriteConddiretiva nos permite adicionar condições às nossas regras de reescrita para controlar quando as regras serão processadas. Todos RewriteCondsseguem o seguinte formato:

Estrutura geral RewriteCond
RewriteCond TestString Condition [Flags]
RewriteCondespecifica a RewriteConddiretiva.
TestString é a cadeia de caracteres para testar.
Condition é o padrão ou condição a ser correspondida.
Flags são parâmetros opcionais que podem modificar as condições e as regras de avaliação.
Se um for RewriteCondavaliado como verdadeiro, o RewriteRuleseguinte será considerado. Caso contrário, a regra será descartada. Vários RewriteCondpodem ser usados ​​um após o outro e, com comportamento padrão, todos devem ser avaliados como true para que a regra a seguir seja considerada.

Como exemplo, suponha que você gostaria de redirecionar todas as solicitações para arquivos ou diretórios inexistentes em seu site de volta à página inicial, em vez de mostrar a página de erro 404 Não encontrada padrão . Isso pode ser alcançado com as seguintes regras de condições:

Redirecionar todas as solicitações para arquivos e diretórios inexistentes para a página inicial
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /
Com o acima exposto:

%{REQUEST_FILENAME}é a string a ser verificada. Nesse caso, é o nome do arquivo solicitado, que é uma variável do sistema disponível para cada solicitação.
-fé uma condição interna que verifica se o nome solicitado existe no disco e é um arquivo. O !é um operador de negação. Combinado, !-favalia como true somente se um nome especificado não existir ou não for um arquivo.
Da mesma forma, !-davalia como true apenas se um nome especificado não existir ou não for um diretório.
A RewriteRulelinha final entrará em vigor apenas para solicitações de arquivos ou diretórios inexistentes. O RewriteRulepróprio é muito simples e redireciona todas as solicitações para a /raiz do site.

Conclusão
mod_rewritepermite criar URLs legíveis por humanos. Neste tutorial, você aprendeu como usar a RewriteRulediretiva para redirecionar URLs, incluindo aqueles com cadeias de consulta. Você também aprendeu como redirecionar condicionalmente URLs usando a RewriteConddiretiva.

Se você quiser saber mais mod_rewrite, consulte a Introdução do mod_rewrite do Apache e a documentação oficial do Apache para o mod_rewrite .
