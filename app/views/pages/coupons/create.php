<?php


App\Core\UI::partial('header');
App\Core\Notify::show();

?>

<div class="container">

    <h3>Novo Cupom</h3>
    <hr>

    <form action="/coupons/store" method="POST">
        <div class="row">
            <div class="col-4">

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control" id="name" required />
                </div>

                <div class="mb-3 row">
                    <div class="col-6">
                        <label for="cd" class="form-label">Código</label>
                        <input type="text" name="code" class="form-control text-uppercase" maxlength="6" minlength="6" id="cd" required />
                    </div>
                    <div class="col-6">
                        <label for="qt" class="form-label">Quantidade</label>
                        <input type="number" name="quantity" class="form-control" min="0" value="1" id="qt" required />
                    </div>
                </div>

                <div class="mb-3">
                    <label for="expire" class="form-label">Vencimento</label>
                    <input type="datetime-local" name="expire_at" class="form-control" id="expire" required />
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" rows="3" name="describe" placeholder="Descreva o produto"></textarea>
                </div>

            </div>

            <div class="col-4">

                <!-- Tipo de regra -->
                <label class="form-label d-block mb-2 fw-bold">Regras</label>
                <div class="form-check form-switch">
                    <input class="form-check-input check-rule" type="checkbox" id="minValue" name="rule_method[]" value="value" />
                    <label class="form-check-label" for="minValue">Aplicação por valor mínimo</label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input check-rule" type="checkbox" id="minQuant" name="rule_method[]" value="quantity" />
                    <label class="form-check-label" for="minQuant">Aplicação por quantidade mínima</label>
                </div>

                <!-- Valor da regra -->
                <div class="row mb-5">
                    <div class="mb-3 mt-3 col-6 input-method-value d-none">
                        <label class="form-label">Valor Minimo da compra (R$)</label>
                        <input type="text" step="any" id="rule-min-value" class="form-control" name="rule_min_value"
                            placeholder="Ex: 100.00" />
                    </div>

                    <div class="mb-3 mt-3 col-6 input-method-quantity d-none">
                        <label class="form-label">Quantidade minima de itens</label>
                        <input type="number" step="any" class="form-control" name="rule_min_quantity"
                            placeholder="Ex: 100.00" />
                    </div>
                </div>

                <!-- Método de desconto -->
                <label class="form-label d-block mb-2 fw-bold">Método de desconto</label>

                <div class="row">
                    <div class="col-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="radio" id="discountValue" name="discount_method" value="value"
                                checked>
                            <label class="form-check-label" for="discountValue">Por valor</label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="radio" id="discountPercent" name="discount_method" value="percent">
                            <label class="form-check-label" for="discountPercent">Por percentual</label>
                        </div>
                    </div>
                </div>


                <!-- Valor do abatimento -->
                <div class="mb-3 mt-3 input-discount-value">
                    <label class="form-label">Valor do desconto (R$)</label>
                    <input type="text" id="discount-value" step="any" class="form-control" name="discount_value" placeholder="Ex: R$ 20,00" />
                </div>

                <div class="mb-3 mt-3 d-none input-discount-percent">
                    <label class="form-label">Percentual do desconto (%)</label>
                    <input type="number" step="any" class="form-control" name="discount_value" min="1" max="100" placeholder="Ex: 30" />
                </div>

                <hr>

                <button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-floppy-fill"></i> Gerar Cupom</button>
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