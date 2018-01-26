
<html>
<head><title>Orders</title></head>
<body>
<a href="/">На главную</a></h3>
<table border=1>
    <h3>Расходные ордера</h3>
    <tr>
        <td>ID</td>
        <td>Наименование</td>
        <td>Остаток</td>
        <td>Расход</td>
        <td>Цена</td>
        <td>Сумма</td>
        <td>Покупатель</td>
        <td>Тел.</td>
        <td>e-mail</td>
        <td>Дата</td>
    </tr>
    @foreach ($orderwithdrawals as $orderwithdrawal)
        <tr>
            <td>{{ $orderwithdrawal->orderID }}</td>
            <td>{{ $orderwithdrawal->name }}</td>
            <td>{{ $orderwithdrawal->balancebegin }}</td>
            <td>{{ $orderwithdrawal->orderwithdrawal }}</td>
            <td>{{ $orderwithdrawal->price }}</td>
            <td>{{ $orderwithdrawal->totalSum }}</td>
            <td>{{ $orderwithdrawal->buyer }}</td>
            <td>{{ $orderwithdrawal->phonenumber}}</td>
            <td>{{ $orderwithdrawal->email }}</td>
            <td>{{ $orderwithdrawal->dateReceipt }}</td>
            <td><a href="/orderwithdrawal/delete/{{ $orderwithdrawal->orderID}}/{{ $orderwithdrawal->goodID }}/{{ $orderwithdrawal->orderwithdrawal }}/{{$orderwithdrawal->price}}">Удалить</a></td>
        </tr>
    @endforeach
</table>
<h3><a href="/orderwithdrawal/create/">Добавить ордер</a></h3>
</body>
</html>