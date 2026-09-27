# API de Consulta de CEP

Projeto desenvolvido em Laravel com integração à API ViaCEP.

A aplicação permite consultar um CEP, armazenar o endereço consultado no banco de dados PostgreSQL e manter um histórico dos endereços já consultados.

O sistema também possui um contador de consultas. Caso o CEP já exista no banco de dados, uma nova chamada ao ViaCEP não é realizada. Nesse caso, o endereço salvo é retornado e o campo `consultas` é incrementado.

---

## Tecnologias utilizadas

- PHP
- Laravel
- PostgreSQL
- Composer
- ViaCEP

---

## Como clonar o projeto

Clone o repositório utilizando o Git:

```bash
git clone URL_DO_REPOSITORIO
```

Depois entre na pasta do projeto:

```bash
cd api_laravel
```

---

## Instalação das dependências

Com o Composer instalado, execute:

```bash
composer install
```

---

## Configuração do ambiente

Crie o arquivo `.env` a partir do `.env.example`.

No Windows:

```bash
copy .env.example .env
```

No Linux ou macOS:

```bash
cp .env.example .env
```

Depois gere a chave da aplicação:

```bash
php artisan key:generate
```

---

## Configuração do banco de dados

Crie um banco de dados PostgreSQL para o projeto.

Depois configure o arquivo `.env` com os dados do banco:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nome_do_banco
DB_USERNAME=postgres
DB_PASSWORD=sua_senha
```

Após configurar o `.env`, execute:

```bash
php artisan config:clear
```

---

## Como rodar o projeto

Execute as migrations para criar as tabelas no banco de dados:

```bash
php artisan migrate
```

Depois inicie o servidor Laravel:

```bash
php artisan serve
```

Por padrão, o projeto ficará disponível em:

```text
http://127.0.0.1:8000
```

---

## Rotas disponíveis da API

### Listar endereços consultados

Método:

```text
GET
```

URL:

```text
/api/enderecos
```

URL completa:

```text
http://127.0.0.1:8000/api/enderecos
```

Essa rota retorna todos os endereços já armazenados no banco de dados.

Exemplo utilizando cURL:

```bash
curl.exe http://127.0.0.1:8000/api/enderecos
```

Exemplo de resposta:

```json
[
    {
        "id": 1,
        "cep": "01001000",
        "logradouro": "Praça da Sé",
        "bairro": "Sé",
        "localidade": "São Paulo",
        "uf": "SP",
        "consultas": 2
    }
]
```

---

### Consultar um CEP

Método:

```text
GET
```

URL:

```text
/api/enderecos/{cep}
```

O `{cep}` deve ser substituído pelo CEP que será consultado.

Exemplo:

```text
http://127.0.0.1:8000/api/enderecos/01001000
```

Também é possível consultar utilizando o CEP com hífen:

```text
http://127.0.0.1:8000/api/enderecos/01001-000
```

Exemplo utilizando cURL:

```bash
curl.exe http://127.0.0.1:8000/api/enderecos/01001000
```

Ao realizar uma consulta, a aplicação primeiro verifica se o CEP já existe no banco de dados.

Caso o CEP já esteja salvo:

- o ViaCEP não é consultado novamente;
- o campo `consultas` é incrementado;
- o endereço salvo é retornado.

Caso o CEP ainda não esteja salvo:

- a aplicação consulta a API ViaCEP;
- os dados do endereço são armazenados no PostgreSQL;
- o contador de consultas inicia em `1`;
- o endereço é retornado em formato JSON.

Exemplo de resposta:

```json
{
    "id": 1,
    "cep": "01001000",
    "logradouro": "Praça da Sé",
    "bairro": "Sé",
    "localidade": "São Paulo",
    "uf": "SP",
    "consultas": 1
}
```

---

## Tratamento de erros

### CEP com formato inválido

Caso o CEP informado não possua 8 dígitos, a API retorna o status HTTP:

```text
400 Bad Request
```

Exemplo de resposta:

```json
{
    "mensagem": "CEP inválido."
}
```

### CEP não encontrado

Caso o ViaCEP informe que o CEP não existe, a API retorna:

```text
404 Not Found
```

Exemplo de resposta:

```json
{
    "mensagem": "CEP não encontrado."
}
```

---

## Interface Web

O projeto também possui uma interface simples para realizar consultas e visualizar os endereços já armazenados.

Acesse:

```text
http://127.0.0.1:8000/enderecos
```

Na página é possível informar um CEP e visualizar o histórico de endereços consultados.