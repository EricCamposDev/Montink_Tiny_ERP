<!-- app/views/produtos/index.php -->
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Novo Produto</h1>

    <div class="row">
        <div class="col-4">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nome do Produto</label>
                    <input type="text" name="name" class="form-control" id="nome" placeholder="Digite o nome">
                </div>

                <div class="mb-3">
                    <label for="mask-money" class="form-label">Preço</label>
                    <input type="text" class="form-control" name="price" data-max-digits="15" maxlength="20" id="mask-money" placeholder="Valor em R$">
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" rows="4" name="describe" placeholder="Descreva o produto"></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><strong>Salvar</strong></button>
            </form>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>