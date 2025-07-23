<?php


    use App\Core\UI;

    UI::partial('header');
    App\Core\Notify::show();
?>

<div class="container">

    <h3>
        <a href="/products/skus/create/<?= App\Core\UI::encrypt($skus[0]['id_product']); ?>" class="btn btn-info fw-bold">Novo SKU <i class="bi bi-plus-circle-dotted"></i></a> ||
        <img class="img-thumbnail" width="50" height="50" src="<?=UI::thumb('default'); ?>" alt=""> 
        <?=$skus[0]['product_name']; ?> - Gerenciar SKUs
    </h3>
    <hr>

    <table class="table">
        <thead class="table-dark">
            <tr class="text-center">
                <th>#</th>
                <th class="text-start">produto SKU</th>
                <th>valor</th>
                <th>estoque</th>
                <th>ações</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($skus as $sku):
        ?>
            <tr class="fw-bold text-center">
                <td>01</td>
                <td class="text-start">
                    <img class="img-thumbnail" width="35" height="35" src="<?=UI::thumb($sku['sku_image']); ?>" alt="">
                    <?=$sku['sku_name']; ?>
                </td>
                <td>R$ <?=number_format($sku['sku_price'], 2); ?></td>
                <td><?=$sku['inventory_quantity']; ?></td>
                <td>
                    <a type="button" title="Editar SKU" class="btn btn-info btn-sm" href="/products/sku/edit/<?=UI::encrypt($sku['id_sku']); ?>"><i class="bi bi-pencil"></i> </a>
                    <button type="button" title="Deletar SKU" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
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