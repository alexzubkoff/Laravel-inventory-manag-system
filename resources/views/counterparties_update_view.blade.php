<html>
<head>
    <title>Update</title>
</head>
<body>
<a href="/">На главную</a></h3>
<h3>Редактировать контрагента</h3>
<form action="/counterparties/update/<?php echo $counterparty['id'];?>" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
    <input type="hidden" name="id" value="<?php echo $counterparty['id'] ?>">
    <table>
        <tr>
        <td>Тип</td>
        <td><input type="radio" name="type" value="provider"> Поставщик<Br>
            <input type="radio" name="type" value="buyer"> Покупатель<Br>
        </td>
        </tr>
        <tr>
            <td>Наименование</td>
            <td><input type="text" name="name" value="<?php echo $counterparty['name'];?>" required/></td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><input type="tel" name="phonenumber"value="<?php echo $counterparty['phonenumber'];?>" required /></td>
        </tr>
        <tr>
            <td>e-mail</td>
            <td><input type="email" name="email" value="<?php echo $counterparty['email'];?>" required/></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="Изменить" /></td>
            <td colspan="2" align="center" ><input id="cancel"  type="reset" value="Отменить" required/></td>
        </tr>
    </table>
</form>
</body>
</html>