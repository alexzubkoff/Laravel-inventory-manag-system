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
<h3>Добавить контрагента</h3>
<form action="/counterparties/create" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
    <table>
        <tr>
            <td>Тип</td>
            <td><input type="radio" name="type" value="provider"> Поставщик<Br>
                <input type="radio" name="type" value="buyer"> Покупатель<Br>
            </td>
        </tr>
        <tr>
            <td>Наименование</td>
            <td><input type="text" name="name" required/></td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><input type="tel" name="phonenumber" required/></td>
        </tr>
        <tr>
            <td>e-mail</td>
            <td><input type="email"  name="email" required/></td>
        </tr>
        <tr>
            <td colspan="2" align="center" ><input type="submit" value="Добавить" /></td>
            <td colspan="2" align="center" ><input id="cancel"  type="reset" value="Отменить" /></td>
        </tr>
    </table>
</form>
</body>
</html>