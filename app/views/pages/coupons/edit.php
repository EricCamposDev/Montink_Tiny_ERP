<?php


App\Core\UI::partial('header');
App\Core\Notify::show();

?>

<div class="container">

    <h3><?=$coupon['coupon_name']; ?> - Editar Cupom</h3>
    <hr>

    <form action="/coupons/edit/<?=App\Core\UI::encrypt($coupon['id_coupon']); ?>" method="POST">
        <div class="row">
            <div class="col-4">

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control" id="name" value="<?=$coupon['coupon_name']; ?> " required />
                </div>

                <div class="mb-3 row">
                    <div class="col-6">
                        <label for="cd" class="form-label">Código</label>
                        <input type="text" name="code" class="form-control text-uppercase" value="<?=$coupon['coupon_code']; ?> " maxlength="6" minlength="6" id="cd" required />
                    </div>
                    <div class="col-6">
                        <label for="qt" class="form-label">Quantidade</label>
                        <input type="number" name="quantity" class="form-control" min="0" value="<?=$coupon['coupon_quantity']; ?>" id="qt" required />
                    </div>
                </div>

                <div class="mb-3">
                    <label for="expire" class="form-label">Vencimento</label>
                    <input type="datetime-local" name="expire_at" class="form-control" value="<?=date('Y-m-d\TH:i', strtotime($coupon['coupon_expire_at'])); ?>" id="expire" required />
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" rows="3" name="describe" placeholder="Descreva o produto"><?=$coupon['coupon_describe']; ?> </textarea>
                </div>

            </div>

            <div class="col-4">

                <?php
                    $rule_min_quantity = ($coupon['coupon_rule_min_quantity'] != 0) ? true : false;
                    $rule_min_value = ($coupon['coupon_rule_min_value'] != 0) ? true : false;
                ?>

                <!-- Tipo de regra -->
                <label class="form-label d-block mb-2 fw-bold">Regras</label>
                <div class="form-check form-switch">
                    <input class="form-check-input check-rule" type="checkbox" id="minValue" name="rule_method[]" value="value" <?=($rule_min_value) ? 'checked' : ''; ?> />
                    <label class="form-check-label" for="minValue">Aplicação por valor mínimo</label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input check-rule" type="checkbox" id="minQuant" name="rule_method[]" value="quantity" <?=($rule_min_quantity) ? 'checked' : ''; ?> />
                    <label class="form-check-label" for="minQuant">Aplicação por quantidade mínima</label>
                </div>

                <!-- Valor da regra -->
                <div class="row mb-5">
                    <div class="mb-3 mt-3 col-6 input-method-value <?=($rule_min_value) ? '' : 'd-none'; ?>">
                        <label class="form-label">Valor Minimo da compra (R$)</label>
                        <input type="text" step="any" id="rule-min-value" class="form-control" name="rule_min_value" placeholder="Ex: 100.00" <?=($rule_min_value) ? ' value="R$ '.number_format($coupon['coupon_rule_min_value'], 2, ',','.').'" ' : ''; ?> />
                    </div>

                    <div class="mb-3 mt-3 col-6 input-method-quantity <?=($rule_min_quantity) ? '' : 'd-none'; ?>">
                        <label class="form-label">Quantidade minima de itens</label>
                        <input type="number" step="any" class="form-control" name="rule_min_quantity" placeholder="Ex: 100.00" <?=($rule_min_quantity) ? ' value="'.$coupon['coupon_rule_min_quantity'].'" ' : ''; ?> />
                    </div>
                </div>

                <!-- Método de desconto -->
                <label class="form-label d-block mb-2 fw-bold">Método de desconto</label>

                <?php
                    $percent_method = false;
                    $value_method = false;

                    if( $coupon['coupon_rule_method_discount'] == 'percent' ){

                    }
                ?>

                <?=($coupon['coupon_rule_method_discount'] == 'percent')?'checked':''; ?>

                <div class="row">
                    <div class="col-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="radio" id="discountValue" name="discount_method" value="value" <?=($coupon['coupon_rule_method_discount'] == 'value')?'checked':''; ?>>
                            <label class="form-check-label" for="discountValue">Por valor</label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="radio" id="discountPercent" name="discount_method" value="percent" <?=($coupon['coupon_rule_method_discount'] == 'percent')?'checked':''; ?>>
                            <label class="form-check-label" for="discountPercent">Por percentual</label>
                        </div>
                    </div>
                </div>


                <!-- Valor do abatimento -->
                <div class="mb-3 <?=($coupon['coupon_rule_method_discount'] == 'value')?'':'d-none'; ?>  mt-3 input-discount-value">
                    <label class="form-label">Valor do desconto (R$)</label>
                    <input type="text" id="discount-value" step="any" class="form-control" name="discount_value" value="<?=($coupon['coupon_rule_method_discount'] == 'value') ? 'R$ ' . number_format($coupon['coupon_rule_value_discount'], 2, ',', '.'):''; ?>" placeholder="Ex: R$ 20,00" />
                </div>

                <div class="mb-3 mt-3 <?=($coupon['coupon_rule_method_discount'] == 'percent')?'':'d-none'; ?> input-discount-percent">
                    <label class="form-label">Percentual do desconto (%)</label>
                    <input type="number" step="any" class="form-control" name="discount_value" min="1" max="100" value="<?=($coupon['coupon_rule_method_discount'] == 'percent')?$coupon['coupon_rule_value_discount']:''; ?>" placeholder="Ex: 30" />
                </div>

                <hr>

                <button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-floppy-fill"></i> Salvar</button>
            </div>
        </div>
    </form>

</div>

<?php App\Core\UI::partial('footer'); ?>

<script>
    $(function() {
        $(".check-rule").change(function() {
            switch($(this).val()){
                case 'value':
                    if( $(this).is(":checked") ){
                        $(".input-method-value").removeClass("d-none")
                    }else{
                        $(".input-method-value").addClass("d-none")
                    }
                break;
                case 'quantity':
                    if( $(this).is(":checked") ){
                        $(".input-method-quantity").removeClass("d-none")
                    }else{
                        $(".input-method-quantity").addClass("d-none")
                    }
                break;
            }
        })

        $("input[name=discount_method]").change(function() {
            if( $(this).val() == "percent" ){
                $(".input-discount-percent").removeClass("d-none")
                $(".input-discount-value").addClass("d-none")
            }else{
                $(".input-discount-value").removeClass("d-none")
                $(".input-discount-percent").addClass("d-none")
            }
        })
    })

    document.getElementById('rule-min-value').addEventListener('input', maskMoney);
    document.getElementById('discount-value').addEventListener('input', maskMoney);

</script>