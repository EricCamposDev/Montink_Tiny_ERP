<?php
    App\Core\UI::partial('header');
?>

<div class="container">

    <h2>Editar SKU | <?=$sku_edit['sku_name']; ?></h2>

    <hr>

    <form action="<?=APP_PATH_INDEX; ?>/products/skus/update" method="POST">
        <div class="row">
            <div class="col-4">

                <input type="hidden" name="id_sku" value="<?=App\Core\UI::encrypt($sku_edit['id_sku']); ?>" />
                <input type="hidden" name="product_id" value="<?=App\Core\UI::encrypt($sku_edit['product_id']); ?>" />

                <div class="mb-3">
                    <label for="name" class="form-label">Nome de variação</label>
                    <input type="text" name="name" class="form-control" id="name" value="<?=$sku_edit['sku_name']; ?>" />
                </div>

                <div class="mb-3 mt-3">
                    <label for="mask-money" class="form-label">Valor (R$)</label>
                    <input type="text" class="form-control" name="price" data-max-digits="15" value="R$ <?=number_format($sku_edit['sku_price'],2); ?>" maxlength="20"
                        id="mask-money" placeholder="Valor em R$">
                </div>

                <div class="mb-3 mt-3">
                    <label for="inventory" class="form-label">Saldo (estoque)</label>
                    <input type="number" class="form-control" name="quantity" id="inventory" value="<?=$sku_edit['inventory_quantity']; ?>" placeholder="ex: 23">
                </div>
            </div>

            <div class="col-8">

                <div class="mb-3">
                    <label for="desc" class="form-label">Descrição de variação</label>
                    <textarea class="form-control" id="desc" rows="3" name="describe"><?=$sku_edit['sku_describe']; ?></textarea>
                </div>

                <div class="mt-5">
                    <h5>Imagem de produto (selecione da galeria)</h5>
                    <?php 
                        for ($thumb = 1; $thumb <= 7; $thumb++):
                            $checked = ($sku_edit['sku_image'] == $thumb) ? ' checked="true" ' : '';
                    ?>
                        <input type="radio" class="btn-check" name="image" value="<?=$thumb; ?>" id="option<?= $thumb; ?>" autocomplete="off" <?=$checked; ?> />
                        <label class="btn" for="option<?= $thumb; ?>">
                            <img src="<?= App\Core\UI::thumb($thumb); ?>" width="50" height="50" alt="">
                        </label>
                    <?php endfor; ?>
                </div>

                <button type="submit" class="btn btn-info fw-bold mt-4"><i class="bi bi-floppy-fill"></i> Salvar SKU</button>
            </div>
        </div>

</div>

<?php
    App\Core\UI::partial('footer');
?>