<?php


    App\Core\UI::partial('header');
    App\Core\Notify::show();

?>

<div class="container">

    <h3><button type="button" class="btn btn-warning fw-bold" data-bs-toggle="modal" data-bs-target="#newProduct"><i class="bi bi-plus-circle-dotted"></i> Novo Produto</button> || Meus Produtos</h3>
    <hr>

    <!-- new product -->
    <div class="modal fade" id="newProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="products/store" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Novo produto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Produto</label>
                            <input type="text" name="name" class="form-control" id="name" />
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" rows="4" name="describe"
                                placeholder="Descreva o produto"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-floppy-fill"></i> Cadastrar Produto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- new product -->

    <table class="table">
        <thead class="table-dark">
            <tr class="align-middle text-center fw-bold">
                <th>#</th>
                <th class="text-start">produto</th>
                <th>SKU</th>
                <th>registro</th>
                <th>atualização</th>
                <th>ações</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $counter = 0;
            foreach ($products as $product):

                $counter++;
                $counter = ($counter < 10) ? '0' . $counter : $conter;
        ?>
            <tr class="align-middle text-center fw-bold">
                <td><?=$counter; ?></td>
                <td class="text-start">
                    <img src="<?= App\Core\UI::thumb(@$product['sku_image']); ?>" class="img-thumbnail" width="35" height="35" alt="">
                    <?= $product['product_name']; ?>
                </td>
                <td>
                    <?php if($product['total_skus'] > 0): ?>
                    
                    <button type="button" class="btn">
                        total <span class="badge text-bg-warning"><?=$product['total_skus']; ?></span>
                    </button>

                    <?php else: ?>
                    sem SKU. <a href="/products/skus/create/<?= App\Core\UI::encrypt($product['id_product']); ?>" class="btn btn-sm btn-info fw-bold">Novo SKU <i class="bi bi-plus-circle-fill"></i></a>
                    <?php endif; ?>
                </td>
                <td><?=date("d/m/y h:i", strtotime($product['product_created_in'])); ?></td>
                <td><?=date("d/m/y h:i", strtotime($product['product_updated_in'])); ?></td>
                <td>
                    <a href="/products/skus/manager/<?= App\Core\UI::encrypt($product['id_product']); ?>" type="button" class="btn btn-warning" title="Gerenciar SKUs de Produto"><i class="bi bi-boxes"></i></a>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editProduct<?=$product['id_product']; ?>"><i class="bi bi-pencil-square"></i></button>
                    <!-- edit product -->
                    <div class="modal fade" id="editProduct<?=$product['id_product']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content text-start">
                                <form action="products/update/<?=App\Core\UI::encrypt($product['id_product']); ?>" method="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel"><?=$product['product_name']; ?> - Editar</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nome do Produto</label>
                                            <input type="text" name="name" class="form-control" value="<?=$product['product_name']; ?>" id="name" />
                                        </div>

                                        <div class="mb-3">
                                            <label for="descricao" class="form-label">Descrição</label>
                                            <textarea class="form-control" id="descricao" rows="4" name="describe" placeholder="Descreva o produto"><?=$product['product_name']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-floppy-fill"></i> Salvar Produto</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdropDelete-<?= $product['id_product']; ?>"><i class="bi bi-trash"></i></button>
                    <!-- delete product -->
                    <div class="modal fade" id="staticBackdropDelete-<?= $product['id_product']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="products/delete/<?=App\Core\UI::encrypt($product['id_product']); ?>" method="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir produto</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Vocẽ tem certeza que deseja deletar esse produto?</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger fw-bold"><i class="bi bi-trash"></i> Sim, Excluir Produto</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- delete product -->
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