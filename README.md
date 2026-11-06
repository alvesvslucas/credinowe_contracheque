# Credinowe — Portal Contracheque

Aplicação web em PHP com entradas separadas para administração e funcionários. Após autenticação, o funcionário consulta o link de seu contracheque.

## Estrutura

| Caminho | Finalidade |
| --- | --- |
| `index.php` | Entrada com seleção do tipo de acesso |
| `pages/admin_login.php` | Acesso administrativo |
| `pages/login_funcionario.php` | Autenticação do funcionário |
| `pages/contracheque.php` | Consulta do contracheque da sessão |
| `assets/` e `includes/` | Estilos, imagens e conteúdo compartilhado |
| `banco/credinowe.sql` | Arquivo SQL existente; revisar antes de usar |
| `config.php` | Configuração de conexão requerida pelas páginas |

## Ambiente local

É necessário um servidor PHP com sessões e PDO, além do banco e do driver PDO correspondentes à configuração da aplicação. A compatibilidade completa da aplicação e um roteiro reproduzível de criação do banco ainda precisam ser confirmados; as checagens isoladas abaixo usam PHP 8.2.

```sh
git clone https://github.com/alvesvslucas/credinowe_contracheque.git
cd credinowe_contracheque
```

1. Prepare uma base de teste a partir de um esquema revisado, sem copiar dados pessoais ou credenciais de produção. O conteúdo do arquivo SQL não foi validado nesta revisão.
2. Configure a conexão PDO local usada por `config.php`.
3. Com PHP disponível, inicie um servidor de desenvolvimento na raiz:

```sh
php -S 127.0.0.1:8080 -t .
```

Abra `http://127.0.0.1:8080/`. O acesso depende de contas de teste cadastradas no banco; as senhas do fluxo de funcionário são verificadas com `password_verify`.

## Estado e validação

Foi corrigido o argumento do stream em `pages/importar_usuarios.php`: `$ $handle` → `$handle`, preservando os campos CSV e as consultas existentes.

A [regressão isolada em PHP 8.2](https://github.com/alvesvslucas/credinowe_contracheque/actions/runs/42284437298) foi executada na `main`: reproduziu a falha da expressão anterior e verificou a chamada real corrigida com duas linhas fictícias, quatro campos por linha e fim de arquivo (EOF). O [CI de sintaxe](https://github.com/alvesvslucas/credinowe_contracheque/actions/runs/42284437253) verificou 18 arquivos PHP.

Para repetir o teste isolado com PHP 8.2, na raiz:

```sh
php -n -d error_reporting=-1 -f tests/csv-stream-regression.php
```

Essa checagem não executa upload HTTP, autorização, PDO ou banco. Login, permissões de acesso aos documentos e importação completa ainda precisam de validação em ambiente de teste. Não publique contracheques, dados de funcionários ou configurações de conexão em demonstrações públicas.
