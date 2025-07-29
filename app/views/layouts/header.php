<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[Montink] Tiny ERP - Teste Prático</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/x-icon" href="https://montinkhelp.zendesk.com/hc/theming_assets/01HZGZW22H9PMZRMZ88RV8A87J" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top no-print">
        <div class="container">
            <a class="navbar-brand" href="/"><strong class="text-warning">[Montink]</strong> Tiny ERP</a>
            <div class="navbar-nav">
                <a class="nav-link" href="/store">Loja</a>
                <a class="nav-link" href="/products">Produtos</a>
                <a class="nav-link" href="/orders">Pedidos</a>
                <a class="nav-link" href="/coupons">Cupons</a>
                <a href="javascript:void(0);" class="nav-link text-white cart-nav" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                
                <?php
                    $cart_items = App\Core\Cart::all();
                    if( $cart_items != null && count($cart_items['items']) > 0 ):

                ?>
                    <i class="bi bi-cart4"></i> Carrinho <span class="badge text-bg-warning"><?=(count($cart_items['items']) ?: 0); ?></span>
                <?php
                    endif;
                ?>
                </a>
            </div>
        </div>
    </nav>

    <br><br><br>
<div id="minicart">
    <?php include __DIR__. "/../pages/store/cart.php"; ?>
</div>