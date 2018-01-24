
<html>
<head><title>Goods</title></head>
<body>
<a href="/">На главную</a></h3>
<table border=1>
    <h3>Товары</h3><h3>
<tr>
 <td>ID</td>
 <td>Наименование</td>
    <td>Кол-во</td>
    <td>Цена</td>
    <td></td>
    <td></td>
</tr>
@foreach ($goods as $good)
    <tr>
        <td>{{ $good->id }}</td>
        <td>{{ $good->name }}</td>
        <td>{{ $good->quantity }}</td>
        <td>{{ $good->price }}</td>
        <td><a href="/goods/update/{{ $good->id }}">Редакт.</a></td>
        <td><a href="/goods/delete/{{ $good->id }}">Удалить</a></td>
    </tr>
    @endforeach
    </table>
<h3><a href="/goods/create/">Добавить</a></h3>
    </body>
    </html>