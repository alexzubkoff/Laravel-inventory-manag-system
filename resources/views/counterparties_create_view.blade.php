<html>
<head>
    <title>Create</title>
</head>
<body>
<div class="links">
    <a href="/" >На главную</a></h3>
</div>
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
            <td><input type="text" name="name" /></td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><input type="tel" name="phonenumber" /></td>
        </tr>
        <tr>
            <td>e-mail</td>
            <td><input type="email"  name="email" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center" ><input type="submit" value="Добавить" /></td>
        </tr>
    </table>
</form>
</body>
</html>