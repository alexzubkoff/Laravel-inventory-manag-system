<!doctype html>
<html>
<head>
    <title>Goods List</title>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
</head>
<body>
<a href="/">На главную</a></h3>
<table border=1>
    <h3>Список товаров</h3>
    <tr>
        <td>ID</td>
        <td>Наименование</td>
        <td>Цена</td>
        <td></td>
        <td></td>
    </tr>
    @foreach ($goods as $good)
        <tr>
            <td>{{ $good->id }}</td>
            <td>{{ $good->name }}</td>
            <td>{{ $good->price }}</td>
            <td><a href="/goodslist/update/{{ $good->id }}">Редакт.</a></td>
            <td><a href="/goodslist/delete/{{ $good->id }}">Удалить</a></td>
        </tr>
    @endforeach
</table>
<h3>Добавить товар</h3>
<form action="/goodslist/create" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
    <table>
        <tr>
            <td>Наименование</td>
            <td><input id='auto' type="text" name="name"  required/></td>
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
<script type="text/javascript">
        $( document ).ready(function() {
            $('#auto').autocomplete({
                source: '{!!URL::route('autocomplete')!!}',
                minlenght: 1,
                autoFocus: true,
                select: function (e, ui) {
                    alert(ui);
                }
            });
        });

</script>
</body>
</html>
