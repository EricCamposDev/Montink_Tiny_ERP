<?php

    use App\Enums\OrderStatus;


    App\Core\UI::partial('header');
    App\Core\Notify::show();
?>

<div class="container">

    <h3>Pedidos</h3>
    <hr>

    <table class="table">
        <thead class="table-dark">
            <tr class="align-middle text-center fw-bold">
                <th>#</th>
                <th class="text-start">Codigo</th>
                <th>Cliente</th>
                <th>Valor</th>
                <th>Atualização</th>
                <th>Registro</th>
                <th>ações</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $counter = 0;
            foreach ($orders as $order):

                $counter++;
                $counter = ($counter < 10) ? '0' . $counter : $conter;
                $status = OrderStatus::from(ucfirst(strtolower($order['order_status'])));
            ?>
                <tr class="align-middle text-center fw-bold">
                    <td><?= $counter; ?></td>
                    <td class="text-start"><?= $order['order_code']; ?></td>
                    <td><?= $order['order_client_name']; ?></td>
                    <td><?= "R$ " . number_format($order['order_value_total'],2); ?></td>
                    <td class="bg-<?=$status->badgeColor(); ?>"><?=$order['order_status']; ?></td>
                    <td><?= date("d/m/Y h:i", strtotime($order['order_created_in'])); ?></td>
                    <td>
                        <a href="/orders/invoice/<?=$order['order_code']; ?>" type="button"class="btn btn-secondary" title="Editar cupom"><i class="bi bi-clipboard-fill"></i> invoice</a>
                    </td>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
</div>

<?php
    App\Core\UI::partial('footer');
?>

<script>

</script>