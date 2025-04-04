# Projeto Sou-Fácil

Solicitado no processo seletivo da empresa Sou-Fácil para vaga de Desenvolvedor Fullstack. Um sistema de gerenciamento de `Vendas` e `Recebimentos`.

### Preparação do projeto

Passo a passo para preparar o ambiente de desenvolvimento

#### Clonar o repositório
```bash
~/

git clone https://github.com/daniellucas04/projeto-soufacil.git
```

#### Instalar pacotes do NPM
```bash
~/projeto-soufacil

npm install
```

#### Instalar pacotes do Composer
```bash
~/projeto-soufacil

composer install
```

#### Copiar as variáveis de ambiente
Antes de iniciar o projeto é necessário utilizar o arquivo `.env` para as Variáveis de ambiente que o sistema usa. Basta copiar o arquivo `.env.example` e renomear para `.env`.

#### Gerar a chave de encriptação da aplicação
```bash
~/projeto-soufacil

php artisan key:generate
```

Nesse ponto o projeto está pronto para rodar. Mas antes é necessário rodar as `migrations` para que o Banco de dados obtenha as tabelas padrões do framework e as tabelas que o sistema utiliza.

#### Migrations
```bash
~/projeto-soufacil

php artisan migrate
```

Após todas as tabelas serem criadas será necessário popular o Banco de dados com dados de teste, para isso será necessário rodar os `Seeders` do projeto. 

```
~/projeto-soufacil

php artisan db:seed
```

Após finalizar os `seeds` dois usuários de teste serão gerados: **Master** e **Admin**.

#### Credenciais de login
- E-mail: master@email.com
- Password: master123

<hr>

- E-mail: admin@email.com
- Password: admin123

### Rodando o projeto

Após a [Preparação do Projeto](#preparação-do-projeto) ele estará pronto para rodar sem falhas.

```bash
~/projeto-soufacil

composer run dev
```

#### Informações gerais

- URL padrão: http://127.0.0.1:8000 | http://localhost:8000
- Banco de dados: **projeto_soufacil**

#### Observações

- As `Vendas` estão sendo estruturadas da seguinte forma: Ao criar uma **Venda** para um **Consumidor** a tabela `sales` armazenará as informações gerais da **venda**. Informações como: **preço da parcela**, **data de pagamento da parcela** e **status da parcela** estão armazenados na tabela `receipts`.

- A tela de recebimentos utiliza uma view MySQL `get_all_receipts` para facilitar a busca de dados de um **Recebimento**. Ao marcar um **recebimento** como pago, a alteração ocorre diretamento no recebimento da tabela `receipts`.

#### Bibliotecas adicionais

- [Laravel Phone](https://github.com/Propaganistas/Laravel-Phone)
- [Inputmask](https://github.com/RobinHerbots/Inputmask)
- [CPF/CNPJ Generator](https://github.com/avlima/php-cpf-cnpj-generator)
