<?php


    use App\Core\UI;

    UI::partial('header');
    App\Core\Notify::show();
?>

<div class="container">

    <h3>
        <a href="/products/skus/create/<?= App\Core\UI::encrypt($skus[0]['id_product']); ?>" class="btn btn-warning fw-bold">Novo SKU <i class="bi bi-plus-circle-dotted"></i></a> ||
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
                if( $sku['id_sku'] != null ):
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
                    <a type="button" title="Editar SKU" class="btn btn-secondary btn-sm" href="/products/sku/edit/<?=UI::encrypt($sku['id_sku']); ?>"><i class="bi bi-pencil"></i> </a>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#deleteSku<?=$sku['id_sku']; ?>" title="Deletar SKU" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                    <div class="modal fade" id="deleteSku<?=$sku['id_sku']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="/products/skus/delete/<?=UI::encrypt($sku['id_sku']); ?>" method="POST">
                                <input type="hidden" name="uri_response" value="<?=UI::encrypt($sku['id_product']); ?>" />
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Deletar SKU <?=$sku['sku_name']; ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <h4>Deseja deletar o produto?</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger fw-bold"><i class="bi bi-trash"></i> Sim, Deletar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php
                endif;
            endforeach;
        ?>
        </tbody>
    </table>

</div>

<?php
    App\Core\UI::partial('footer');
?>