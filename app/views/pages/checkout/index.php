<?php

    use App\Core\UI;

    UI::partial('header');
?>

<div class="container">
    <h2 class="fw-bold">Checkout - Finalizar Compra</h2>
    <hr>

    <form action="checkout/create-order" method="POST">

        <div class="row">

            <div class="col-6">
                <!-- cliente -->
                <h5>Cliente</h5>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="cln" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="cln" name="order_client_name" required>
                    </div>
        
                    <div class="mb-3 col-6">
                        <label for="cle" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="cle" name="order_client_email" required>
                    </div>
                </div>
    

                <!-- Itens da Compra -->
                <div class="mb-4">
                    <h5>Itens</h5>
                    <table class="table">
                        <tbody>
                        <?php
                            $c = 0;
                            foreach($cart['items'] as $item):
                                $c++;
                        ?>
                            <tr class="fw-bold">
                                <td><img src="<?=$item['item_image']; ?>" width="30" height="30" alt=""></td>
                                <td><small><?=$item['item_name']; ?></small></td>
                                <td><input class="form-control form-control-sm" style="width: 70px;" type="number" min="1" value="1" /></td>
                                <td><small>R$ <?=number_format($item['item_value'],2); ?></small></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php
                            endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-3">
                <div class="mb-4">
                    <h5>CEP (cálculo de frete)</h5>
                    <div class="mb-4">
                        <div class="input-group zipcode-search">
                            <input type="text" class="form-control" id="zipcode" placeholder="ex: 60020-050" maxlength="9" oninput="maskZipcode(this)" />
                        </div>

                        <div class="freight-card">
                            <?php if( $freight ): ?>
                            <div class="card mt-3 freight">
                                <div class="card-header fw-bold">
                                    <small class="f-name"><i class="bi bi-truck"></i> - <?=$freight['method']; ?> (R$ <?=number_format($freight['value'],2); ?>)</small>
                                </div>
                                <div class="card-body">

                                    <figure>
                                        <blockquote class="blockquote">
                                            <p class="f-zipcode"><?=$freight['zipcode']; ?></p>
                                        </blockquote>
                                        <figcaption class="blockquote-footer f-address"><?=$freight['address']; ?></figcaption>
                                    </figure>

                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-3">


                <div class="mb-4">
                    
                    <?php if($discount): ?>
                    <div class="btn-group">
                        <button class="btn btn-warning  fw-bold">Cupom: <?=$discount['coupon_code']; ?></button>
                        <a href="checkout/remove-coupon" class="btn btn-dark"><i class="bi bi-x-lg"></i></a>
                    </div>
                    <?php else: ?>
                
                    <h5>Cupom de Desconto</h5>
                    <div class="input-group checkout-coupon mb-2">
                        <input type="text" id="coupon" class="form-control" maxlength="6" placeholder="Digite o cupom">
                    </div>
                    <strong class="coupon-feedback"></strong>

                    <?php endif; ?>
                </div>

                <div id="cart-totals">
                <div class="mb-4">
                        <h5>Resumo</h5>
                        <p>Subtotal: <span id="t-subtotal" class="fw-bold">R$
                                <?= number_format($insights['subtotal'], 2); ?></span></p>
                        <p><i class="bi bi-percent"></i> Desconto: <span id="t-discount" class="fw-bold">R$
                                <?= number_format($insights['discount'], 2); ?></span></p>
                        <p><i class="bi bi-truck"></i> Frete: <span id="t-freight" class="fw-bold">R$
                                <?= number_format($insights['freight'], 2); ?></span></p>
                        <p>Total: <span id="t-total" class="fw-bold">R$ <?= number_format($insights['total'], 2); ?></span></p>
                    </div>

                    <button type="submit" class="btn btn-warning btn-lg fw-bold w-100"><i class="bi bi-cart-check-fill"></i> Finalizar Compra</button>
                </div>

            </div>

        </div>

    </form>
</div>

<?php UI::partial('footer'); ?>

<script>

    const baseURL = window.location.origin;
    const baseTotalized = baseURL + '/app/views/pages/checkout/totalized.php';

    function maskZipcode(input) {
        const valor = input.value.replace(/\D/g, '');
        input.value = valor.replace(/^(\d{5})(\d)/, '$1-$2');
    }

    const freightCard = `<div class="card mt-3 freight">
                            <div class="card-header fw-bold">
                                <small class="f-name"></small>
                            </div>
                            <div class="card-body">
                                <figure>
                                    <blockquote class="blockquote">
                                        <p class="f-zipcode"></p>
                                    </blockquote>
                                    <figcaption class="blockquote-footer f-address"></figcaption>
                                </figure>
                            </div>
                        </div>`;

    $(function() {

        $("#zipcode").keyup(function()  {
            if( $(this).val().length == 9 ){
                $.get(`https://viacep.com.br/ws/${$(this).val()}/json/`, function(response) {
                    if( typeof response.cep != 'undefined' ){

                        $(".freight-card").html(freightCard)

                        var address = `${response.logradouro}, ${response.bairro}, ${response.localidade}-${response.uf}`;

                        $(".freight").removeClass("d-none")
                        $(".freight").find(".f-zipcode").html(`${response.cep}`)
                        $(".freight").find(".f-address").html(`${response.logradouro}, ${response.bairro}, ${response.localidade}-${response.uf}`)
                        
                        $.post(`${baseURL}/checkout/apply-freight`, {'zipcode': response.cep, 'address': address}, function(responseServer) {
                            console.log(responseServer)
                            $(".f-name").html(`${responseServer.method} (R$ ${responseServer.value.toFixed(2)})`)
                            $("#cart-totalized").load(baseTotalized)
                        });

                    }else{
                        $(".freight").addClass("d-none")
                        $(".freight-card").html('<strong class="text-danger">CEP não encontrado.</strong>')
                    }
                })
            }
        })

        $("#coupon").keyup(function() {
            if( $(this).val().length == 6 ){
                $.post(`${baseURL}/checkout/apply-coupon`, {'code': $(this).val()}, function(response) {
                    console.log(response)
                    if( response.error ){
                        $(".coupon-feedback").removeClass("text-success").addClass("text-danger").html(`<i class="bi bi-x-circle"></i> ${response.message}`)
                    }else{
                        $(".coupon-feedback").removeClass("text-danger").addClass("text-success").html(`<i class="bi bi-check-circle-fill"></i> ${response.message}`)
                        setTimeout(function() {
                            location.reload();
                        }, 1500)
                    }
                })
            }
        })
    })

</script>