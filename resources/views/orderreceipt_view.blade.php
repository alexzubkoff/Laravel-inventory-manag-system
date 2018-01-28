
<html>
<head><title>Orders</title></head>
<body>
<a href="/">На главную</a></h3>
<table border=1>
    <h3>Приходные ордера</h3>
        <tr>
            <td>ID</td>
            <td>Товар</td>
            <td>Цена</td>
            <td>Остаток</td>
            <td>Приход</td>
            <td>Поставщик</td>
            <td>Тел.</td>
            <td>e-mail</td>
            <td>Дата поставки</td>
        </tr>
        @foreach ($orderreceipts as $orderreceipt)
            <tr>
                <td>{{ $orderreceipt->purchaseId }}</td>
                <td>{{ $orderreceipt->productName }}</td>
                <td>{{ $orderreceipt->price }}</td>
                <td>{{ $orderreceipt->stockBalance }}</td>
                <td>{{ $orderreceipt->purchaseQuantity }}</td>
                <td>{{ $orderreceipt->provider }}</td>
                <td>{{ $orderreceipt->phonenumber}}</td>
                <td>{{ $orderreceipt->email }}</td>
                <td>{{ $orderreceipt->purchaseDate }}</td>
                <td><a href="/orderreceipt/delete/{{ $orderreceipt->purchaseId}}/{{ $orderreceipt->productId}}">Удалить</a></td>
            </tr>
        @endforeach
</table>
<h3>Добавить приходный ордер</h3>
<form id = "orderreceipt" action="/orderreceipt/create" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
    <table>
        <tr>
            <td>Поставщики</td>
            <td><select name="supplierslist" form="orderreceipt">
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
        <tr>
            <td>Наименование</td>
            <td><input type="text" name="name" /></td>
        </tr>
        <tr>
            <td>Кол-во</td>
            <td><input id = "quantity" type="number" min = "1" name="quantity" /></td>
        </tr>
        <tr>
            <td>Цена</td>
            <td><input id = "price" type="number" min = "1" name="price" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center" ><input type="submit" value="Сохранить" /></td>
            <td colspan="2" align="center" ><input id="cancel"  type="reset" value="Отменить" /></td>
        </tr>
    </table>
</form>
</body>
</html>