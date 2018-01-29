
<html>
<head><title>Orders</title></head>
<body>
<a href="/">На главную</a></h3>
<table border=1>
    <h3>Расходные ордера</h3>
    <tr>
        <td>ID</td>
        <td>Товар</td>
        <td>Цена</td>
        <td>Остаток</td>
        <td>Расход</td>
        <td>Покупатель</td>
        <td>Тел.</td>
        <td>e-mail</td>
        <td>Дата</td>
    </tr>
    @foreach ($orderwithdrawals as $orderwithdrawal)
        <tr>
            <td>{{ $orderwithdrawal->orderId }}</td>
            <td>{{ $orderwithdrawal->productName }}</td>
            <td>{{ $orderwithdrawal->price }}</td>
            <td>{{ $orderwithdrawal->stockBalance }}</td>
            <td>{{ $orderwithdrawal->orderQuantity }}</td>
            <td>{{ $orderwithdrawal->buyer }}</td>
            <td>{{ $orderwithdrawal->phonenumber}}</td>
            <td>{{ $orderwithdrawal->email }}</td>
            <td>{{ $orderwithdrawal->orderDate }}</td>
            <td><a href="/orderwithdrawal/delete/{{ $orderwithdrawal->orderId}}/{{ $orderwithdrawal->productId }}">Удалить</a></td>
        </tr>
    @endforeach
</table>
<h3>Добавить расходный ордер</h3>
<form id = "orderreceipt" action="/orderwithdrawal/create" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
    <table>
        <tr>
            <td>Покупатели</td>
            <td><select name="supplierslist" form="orderreceipt">
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>Товары на остатке</td>
            <td><select name="goodslist" form="orderreceipt">
                    @foreach ($goods as $good)
                        <option value="{{ $good->id }}">{{ $good->name }}:кол-во&nbsp;{{ $good->quantity }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>Кол-во</td>
            <td><input id = "quantity" type="number" min = "1"  name="quantity" required/></td>
        </tr>
        <tr>
            <td>Цена</td>
            <td><input id = "price" type="number" min = "1" name="price" required/></td>
        </tr>

        <tr>
            <td colspan="2" align="center" ><input type="submit" value="Сохранить" /></td>
            <td colspan="2" align="center" ><input id="cancel"  type="reset" value="Отменить" /></td>
        </tr>
    </table>
</form>
</body>
</html>