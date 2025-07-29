<?php
    App\Core\UI::partial('header');
?>

<div class="container">

    <h2>Novo SKU | <?=$product_name; ?></h2>

    <hr>

    <form action="<?=APP_PATH_INDEX; ?>/products/skus/store" method="POST">
        <div class="row">
            <div class="col-4">

                <input type="hidden" name="product_id" value="<?=$id_product; ?>" />

                <div class="mb-3">
                    <label for="name" class="form-label">Nome de variação</label>
                    <input type="text" name="name" class="form-control" id="name" />
                </div>

                <div class="mb-3 mt-3">
                    <label for="sku-price" class="form-label">Valor (R$)</label>
                    <input type="text" class="form-control" name="price" data-max-digits="15" maxlength="20"
                        id="sku-price" placeholder="Valor em R$">
                </div>

                <div class="mb-3 mt-3">
                    <label for="inventory" class="form-label">Saldo (estoque)</label>
                    <input type="number" class="form-control" name="quantity" id="inventory" placeholder="ex: 23">
                </div>
            </div>

            <div class="col-8">

                <div class="mb-3">
                    <label for="desc" class="form-label">Descrição de variação</label>
                    <textarea class="form-control" id="desc" rows="4" name="describe"></textarea>
                </div>

                <div class="mt-5">
                    <h5>Imagem de produto (selecione da galeria)</h5>
                    <?php for ($thumb = 1; $thumb <= 7; $thumb++): ?>
                        <input type="radio" class="btn-check" name="image" value="<?=$thumb; ?>" id="option<?= $thumb; ?>" autocomplete="off" <?=($thumb==1)?'checked':''; ?> />
                        <label class="btn" for="option<?= $thumb; ?>">
                            <img src="<?= App\Core\UI::thumb($thumb); ?>" width="50" height="50" alt="">
                        </label>
                    <?php endfor; ?>
                </div>

                <button type="submit" class="btn btn-primary fw-bold mt-5">Salvar SKU</button>
            </div>
        </div>

</div>

<?php
    App\Core\UI::partial('footer');
?>

<script>
    document.getElementById('sku-price').addEventListener('input', maskMoney);
</script>