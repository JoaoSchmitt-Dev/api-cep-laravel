<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Consulta de CEP</title>
</head>

<body>

    <h1>Consulta de CEP</h1>

    <form action="/consultar-cep" method="GET">
        <label>CEP:</label>
        <input type="text" name="cep" required>

        <button type="submit">Consultar</button>
    </form>

    <h2>Endereços consultados</h2>

    @foreach ($enderecos as $endereco)
    <p>
        {{ $endereco->cep }} -
        {{ $endereco->logradouro }} -
        {{ $endereco->bairro }} -
        {{ $endereco->localidade }} -
        {{ $endereco->uf }}
    </p>
    @endforeach

</body>

</html>