<!-- app/views/produtos/index.php -->
<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<div class="container">
    <h1>Lista de Produtos</h1>
    
    <a href="/products/create" class="btn btn-primary mb-3">Novo Produto</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $counter = 0;
                foreach ($products as $product):
                    $counter++;
                    $counter = ($counter < 10) ? '0'.$counter : $conter;
            ?>
            <tr>
                <td><?= $counter; ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td>R$ <?= number_format($product['price'], 2, ',', '.') ?></td>
                <td>
                    <a href="/produtos/editar/<?= $product['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdropDelete-<?=$product['id']; ?>">Excluir</button>
                </td>
            </tr>
            
            <!-- edit product -->
            <div class="modal fade" id="staticBackdropDelete-<?=$product['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="products/delete" method="POST">
                            <input type="hidden" name="product_id" value="<?=App\Core\UI::encrypt($product['id']); ?>" required />
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir produto</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h4>Vocẽ tem certeza que deseja deletar esse produto?</h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger">Sim, Excluir Produto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>