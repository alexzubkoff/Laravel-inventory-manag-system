<html>
<head><title>Report</title></head>
<body>
<a href="/">На главную</a></h3>
<table border=1>
    <h3>Отчет</h3>
    <tr>
        <td>ID</td>
        <td>Товар</td>
        <td>Цена</td>
        <td>Остаток</td>
        <td>Приход</td>
        <td>Поставщик</td>
        <td>Дата</td>
        <td>Остаток</td>
        <td>Расход</td>
        <td>Дата</td>
        <td>Остаток</td>
    </tr>
    @foreach ($reports as $report)
        <tr>
            <td>{{ $report->productId }}</td>
            <td>{{ $report->productName }}</td>
            <td>{{ $report->price }}</td>
            <td>{{ $report->purchasBalance }}</td>
            <td>{{ $report->purchaseQuantity }}</td>
            <td>{{ $report->provider }}</td>
            <td>{{ $report->purchaseDate}}</td>
            <td>{{ $report->stockBalance }}</td>
            <td>{{ $report->orderQuantity }}</td>
            <td>{{ $report->orderDate }}</td>
            <td>{{ $report->balance }}</td>
        </tr>
    @endforeach
</table>
<form id = "orderreceipt" action="/report/create" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
    <table>
        <tr>
        <tr>
            <td>Начальная дата</td>
            <td><input type="date" name="datebegin" required/></td>
        </tr>
        <tr>
            <td>Конечная дата</td>
            <td><input type="date"  name="dateend" required/></td>
        </tr>
        <tr>
            <td colspan="2" align="center" ><input type="submit" value="Сформировать отчет" /></td>
            <td colspan="2" align="center" ><input id="cancel"  type="reset" value="Отменить" /></td>
        </tr>
    </table>
</form>
</body>
</html>