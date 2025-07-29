<?php

    use App\Core\UI;
    use App\Enums\OrderStatus;
    
    UI::partial('header');

    $status = OrderStatus::from(ucfirst(strtolower($invoice[0]['order_status'])));
?>

<div class="container">

    <div class="card shadow">
        <div class="card-header fw-bold">
            <h2 class="mb-0">Pedido <strong><?=$invoice[0]['order_code']; ?></strong></h2>
            <h3 class="mt-3">Status <span class="badge text-bg-<?=$status->badgeColor(); ?>"><?=$invoice[0]['order_status'];?></span></h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>De:</h5>
                    <p>
                        Montink Tiny ERP<br>
                        Rua das Flores, 123<br>
                        Fortaleza - CE<br>
                        sac@montink.com
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Para:</h5>
                    <p>
                        <?=$invoice[0]['order_client_name']; ?><br>
                        <?=$invoice[0]['order_client_email']; ?>
                    </p>
                </div>
            </div>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Descrição</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($invoice as $item): ?>
                    <tr>
                        <td><?=$item['product_name']." ".$item['sku_name']; ?></td>
                        <td><?=$item['order_item_quantity']; ?></td>
                        <td>R$ <?=number_format($item['sku_price'], 2); ?></td>
                        <td>R$ <?=number_format(($item['order_item_quantity'] * $item['sku_price']), 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Subtotal</th>
                        <th>R$ <?=number_format(($invoice[0]['order_value_total'] + $invoice[0]['order_total_freight'] + $invoice[0]['order_total_discount']), 2); ?></th>
                        
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Frete</th>
                        <th>R$ <?=number_format($invoice[0]['order_total_freight'], 2); ?></th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Desconto</th>
                        <th>R$ <?=number_format($invoice[0]['order_total_discount'], 2); ?></th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th>R$ <?=number_format($invoice[0]['order_value_total'], 2); ?></th>
                    </tr>
                </tfoot>
            </table>

            <p class="mt-4">Obrigado pela preferência!</p>
        </div>
        <div class="card-footer text-end no-print">
            <button class="btn btn-primary" onclick="window.print()">🖨️ Imprimir</button>
        </div>
    </div>

</div>

<?php UI::partial('footer'); ?>