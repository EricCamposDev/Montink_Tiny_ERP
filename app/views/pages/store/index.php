<?php

    use App\Core\UI;
    use App\Core\Cart;

    UI::partial('header');
    App\Core\Notify::show();

    $cart = Cart::all();
?>

<div class="container">
    <h2 class="fw-bold">loja Montink</h2>
    <hr>

    <?php
    if ($products && $products[0]['id_sku'] != null):
        ?>

        <div class="row">

            <?php

                    $showButtonBuy = true;
                    $showButtonSelector = false;

                    foreach ($products as $product):
                        if ($product['id_sku'] != null):

                            if( $cart && isset($cart['items'][$product['id_sku']]) ){
                                $showButtonBuy = false;
                                $showButtonSelector = true;
                            }elseif( $cart && !isset($cart['items'][$product['id_sku']]) ){
                                $showButtonBuy = true;
                                $showButtonSelector = false;
                            }
            ?>

                    <div class="col-3">
                        <div class="card shadow-sm border-0 mt-3 mb-3">
                            <div class="d-flex justify-content-center">
                                <img src="<?= UI::thumb($product['sku_image']); ?>" style="width: 170px; height: 170px;"
                                    class="card-img-top img-fluid" alt="">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= $product['product_name'] . ' - ' . $product['sku_name']; ?></h5>
                                <h6 class="text-dark mb-3 fw-bold">R$ <?=number_format($product['sku_price'], 2); ?></h6>
                                
                                <button class="btn btn-warning fw-bold w-100 cart-shop <?=($showButtonBuy) ? '' : 'd-none'; ?>">
                                    <i class="bi bi-cart-plus me-2"></i> Comprar

                                    <cart 
                                        meta-1="<?=$product['id_product']; ?>" 
                                        meta-2="<?=$product['id_sku']; ?>"
                                        meta-3="<?=UI::thumb($product['sku_image']); ?>" 
                                        meta-4="<?= $product['product_name'] . ' - ' . $product['sku_name']; ?>"
                                        meta-5="<?=$product['sku_price']; ?>"
                                    ></cart>

                                </button>
                                
                                <div class="quantity-selector input-group input-group-sm mt-3 <?=($showButtonSelector) ? '' : 'd-none'; ?>">
                                    <button class="btn btn-warning fw-bold" type="button" onclick="inputQuantMinus(this)">–</button>
                                    <input type="number" class="form-control text-center fw-bold" value="1" min="1">
                                    <button class="btn btn-warning fw-bold" type="button" onclick="inputQuantPlus(this)">+</button>
                                </div>

                            </div>
                        </div>
                    </div>

            <?php
                        endif;
                    endforeach;
            ?>

        </div>
        <?php
    endif;
    ?>


    
</div>

<?php App\Core\UI::partial('footer'); ?>

<!-- cart toast  notification -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">

  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="<?=UI::thumb(''); ?>" class="rounded me-2" width="30" height="30" alt="...">
      <strong class="me-auto">Meu Carrinho</strong>
      <small>notificação</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body"></div>
  </div>

</div>

<script>

    function inputQuantPlus(btn) {
        const input = btn.parentElement.querySelector('input');
        input.value = parseInt(input.value) + 1;
    }

    function inputQuantMinus(btn) {
        const input = btn.parentElement.querySelector('input');
        const min = parseInt(input.min) || 1;
        if (parseInt(input.value) > min) {
            input.value = parseInt(input.value) - 1;
        }
    }

    const baseURL = window.location.origin;
    const baseCart = baseURL + '/app/views/pages/store/cart.php';

    $(function() {

        const toastLiveExample = document.getElementById('liveToast')
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)

        $(".cart-shop").click(function() {

            $(this).addClass('d-none')
            $(this).parent().find('.quantity-selector').removeClass('d-none')

            var cart = $(this).find('cart')

            $.post(`${baseURL}/store/cart/add-item`, { 
                cart: {
                    'meta-1': cart.attr('meta-1'), 
                    'meta-2': cart.attr('meta-2'), 
                    'meta-3': cart.attr('meta-3'), 
                    'meta-4': cart.attr('meta-4'), 
                    'meta-5': cart.attr('meta-5')
                }
            }, function(response) {

                console.log(response)

                var insights = JSON.parse(response)
                if( insights != null ){

                    if( $.trim($(".cart-nav").html()) == "" ) {
                        $(".cart-nav").html(`<i class="bi bi-cart4"></i> Carrinho <span class="badge text-bg-warning">${insights.products}</span>`)
                    }else{
                        $(".cart-nav").find('span').html(insights.products)
                    }

                    $("#liveToast").find('img').attr('src', cart.attr('meta-3'))
                    $("#liveToast").find(".toast-body").html(`<b>${cart.attr('meta-4')}</b> adicionado ao carrinho.`)
                    
                    toastBootstrap.show()

                    $("#minicart").load(baseCart)
                }
            })

            
        })

    })

</script>