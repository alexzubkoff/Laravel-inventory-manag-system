
<html>
<head><title>Goods</title></head>
<body>
<a href="/">На главную</a></h3>
<table border=1>
    <h3>Товары</h3>
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
<h3>Добавить товар</h3>
<form action="/goods/create" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
    <table>
        <tr>
            <td>Наименование</td>
            <td><input type="text" name="name" required/></td>
        </tr>
        <tr>
            <td>Кол-во</td>
            <td><input type="number" min="1" name="quantity" required/></td>
        </tr>
        <tr>
            <td>Цена</td>
            <td><input type="number" min="0" name="price" required/></td>
        </tr>
        <tr>
            <td colspan="2" align="center" ><input type="submit" value="Добавить" /></td>
            <td colspan="2" align="center" ><input id="cancel"  type="reset" value="Отменить" /></td>
        </tr>
    </table>
</form>
</body>
</html>
    </body>
    </html>