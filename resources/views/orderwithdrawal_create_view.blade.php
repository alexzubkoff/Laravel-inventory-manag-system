<html>
<head>
    <title>Create Order</title>
</head>
<body>
<div class="links">
    <a href="/" >На главную</a></h3>
</div>
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
            <td>Товары</td>
            <td><select name="goodslist" form="orderreceipt">
                    @foreach ($goods as $good)
                        <option value="{{ $good->id }}">{{ $good->name }}</option>
                    @endforeach
                </select>
            </td>
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
            <td>Сумма</td>
            <td><input id="sum" type="number" name="totalSum" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center" ><input type="submit" value="Сохранить" /></td>
            <td colspan="2" align="center" ><input type="submit" value="Отменить" /></td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    var price = document.getElementById("price");
    price.onblur = function () {
        var quantity = document.getElementById("quantity").value;
        document.getElementById("sum").value = quantity*price.value;
    }
</script>
</body>
</html>