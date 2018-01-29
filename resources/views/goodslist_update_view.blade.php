<html>
<head>
    <title>Update</title>
</head>
<body>
<a href="/">На главную</a></h3>
<h3>Редактировать товар</h3>
<form action="/goodslist/update/<?php echo $good['id'];?>" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
    <input type="hidden" name="id" value="<?php echo $good['id'] ?>">
    <table>
        <tr>
            <td>Наименование</td>
            <td><input type="text" name="name" value="<?php echo $good['name'];?>"required/></td>
        </tr>
        <tr>
            <td>Цена</td>
            <td><input type="text" name="price" value="<?php echo $good['price'];?>"required/></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="Изменить" /></td>
            <td colspan="2" align="center" ><input id="cancel"  type="reset" value="Отменить" /></td>
        </tr>
    </table>
</form>
</body>
</html>