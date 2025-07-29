<?php

    include __DIR__ . "/../../../core/bootstrap.php";

    use App\Core\Cart;

    $cart_items = Cart::all();
    $cart_insights = Cart::insights();
?>

<div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-warning fw-bold" id="offcanvasExampleLabel">Meu Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        <?php  
            if( $cart_items ):    
            foreach ($cart_items['items'] as $item): 
        ?>

            <!-- cart item -->
            <div class="card mb-3 text-bg-dark border-0 shadow-sm">
                <div class="row g-0 align-items-center">

                    <!-- Miniatura do produto -->
                    <div class="col-3">
                        <img src="<?=$item['item_image']; ?>" width="80" height="80" class="img-fluid rounded-start"
                            alt="Produto">
                    </div>

                    <!-- Informações do produto -->
                    <div class="col-6">
                        <div class="card-body py-2">
                            <h6 class="card-title"><?= $item['item_name']; ?></h6>
                            <div class="mb-1">
                                <label for="qty-1" class="form-label me-2 mb-0 text-muted">Qtd:</label>
                                <input type="number" id="qty-1" class="form-control form-control-sm" min="1"
                                    value="<?= $item['item_quantity']; ?>" style="max-width: 70px;">
                            </div>
                            <p class="fw-bold text-white">R$ <?= number_format($item['item_value'], 2); ?></p>
                        </div>
                    </div>

                    <!-- Botão de remover -->
                    <div class="col-3 text-end pe-3">
                        <button class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>

                </div>
            </div>
            <!-- ./ -->

        <?php 
            endforeach;
            endif;
        ?>

        <div class="cart-footer border-top pt-3">
            <div class="d-flex justify-content-between">
                <strong>Total:</strong>
                <strong>R$ <?=number_format($cart_insights['subtotal'], 2); ?></strong>
            </div>
            <a href="/store/cart/clear" class="btn btn-secondary fw-bold w-100 mt-3">
                <i class="bi bi-cart-x-fill"></i> Limpar carrinho
            </a>
            <a href="/checkout" class="btn btn-warning fw-bold w-100 mt-1">
                <i class="bi bi-bag-check me-2"></i> Finalizar Compra
            </a>
        </div>


    </div>
</div>