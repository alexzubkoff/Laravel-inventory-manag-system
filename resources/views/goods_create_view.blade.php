<html>
<head>
    <title>Create</title>
</head>
<body>
<div class="links">
<a href="/" >На главную</a></h3>
</div>
<h3>Добавить товар</h3>
<form action="/goods/create" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
    <table>
        <tr>
            <td>Наименование</td>
            <td><input type="text" name="name" /></td>
        </tr>
        <tr>
            <td>Кол-во</td>
            <td><input type="number" name="quantity" /></td>
        </tr>
        <tr>
            <td>Цена</td>
            <td><input type="number" name="price" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center" ><input type="submit" value="Добавить" /></td>
        </tr>
    </table>
</form>
</body>
</html>