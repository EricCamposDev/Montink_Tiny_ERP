<?php
    App\Core\UI::partial('header'); 
?>

<div class="container">

    <h2>Novo Produto</h2>

    <hr>

    <div class="row">
        <div class="col-4">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nome do Produto</label>
                    <input type="text" name="name" class="form-control" id="name" />
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

<?php
    App\Core\UI::partial('footer'); 
?>