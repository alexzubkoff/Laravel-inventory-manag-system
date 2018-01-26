
<html>
<head><title>Orders</title></head>
<body>
<a href="/">На главную</a></h3>
<table border=1>
    <h3>Приходные ордера</h3>
        <tr>
            <td>ID</td>
            <td>Наименование</td>
            <td>Остаток</td>
            <td>Приход</td>
            <td>Цена</td>
            <td>Сумма</td>
            <td>Поставщик</td>
            <td>Тел.</td>
            <td>e-mail</td>
            <td>Дата</td>
        </tr>
        @foreach ($orderreceipts as $orderreceipt)
            <tr>
                <td>{{ $orderreceipt->orderID }}</td>
                <td>{{ $orderreceipt->name }}</td>
                <td>{{ $orderreceipt->balancebegin }}</td>
                <td>{{ $orderreceipt->orderreceipt }}</td>
                <td>{{ $orderreceipt->price }}</td>
                <td>{{ $orderreceipt->totalSum }}</td>
                <td>{{ $orderreceipt->provider }}</td>
                <td>{{ $orderreceipt->phonenumber}}</td>
                <td>{{ $orderreceipt->email }}</td>
                <td>{{ $orderreceipt->dateReceipt }}</td>
                <td><a href="/orderreceipt/delete/{{ $orderreceipt->orderID}}/{{ $orderreceipt->goodID }}/{{ $orderreceipt->orderreceipt }}/{{$orderreceipt->price}}">Удалить</a></td>
            </tr>
        @endforeach
</table>
<h3><a href="/orderreceipt/create/">Добавить ордер</a></h3>
</body>
</html>