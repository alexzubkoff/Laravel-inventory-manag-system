<html>
<head><title>Сounterparties</title></head>
<body>
<a href="/">На главную</a></h3>
<table border=1>
    <h3>Контрагенты</h3><h3>
        <tr>
            <td>ID</td>
            <td>Тип</td>
            <td>Наименование</td>
            <td>Телефон</td>
            <td>e-mail</td>
            <td></td>
            <td></td>
        </tr>
        @foreach ($counterparties as $counterparty)
            <tr>
                <td>{{ $counterparty->id }}</td>
                <td>{{ $counterparty->type }}</td>
                <td>{{ $counterparty->name }}</td>
                <td>{{ $counterparty->phonenumber }}</td>
                <td>{{ $counterparty->email }}</td>
                <td><a href="/counterparties/update/{{ $counterparty->id }}">Редакт.</a></td>
                <td><a href="/counterparties/delete/{{ $counterparty->id }}">Удалить</a></td>
            </tr>
    @endforeach
</table>
<h3><a href="/counterparties/create">Добавить</a></h3>
</body>
</html>