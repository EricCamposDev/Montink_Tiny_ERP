<?php


    App\Core\UI::partial('header');
    App\Core\Notify::show();

?>

<div class="container">

    <h3>
        <a type="button" class="btn btn-warning fw-bold" href="/coupons/create">
            <i class="bi bi-plus-circle-dotted"></i> Novo Cupom
        </a> || Cupons de Desconto
    </h3>
    <hr>

    <table class="table">
        <thead class="table-dark">
            <tr class="align-middle text-center fw-bold">
                <th>#</th>
                <th class="text-start">cupom</th>
                <th>Código</th>
                <th>Quant.</th>
                <th>Registro</th>
                <th>Validade</th>
                <th>ações</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $counter = 0;
            foreach ($coupons as $coupon):

                $counter++;
                $counter = ($counter < 10) ? '0' . $counter : $conter;
                ?>
                <tr class="align-middle text-center fw-bold">
                    <td><?= $counter; ?></td>
                    <td class="text-start"><?= $coupon['coupon_name']; ?></td>
                    <td><?= $coupon['coupon_code']; ?></td>
                    <td><?= $coupon['coupon_quantity']; ?></td>
                    <td><?= date("d/m/y h:i", strtotime($coupon['coupon_created_in'])); ?></td>
                    <td><?= date("d/m/y h:i", strtotime($coupon['coupon_expire_at'])); ?></td>
                    <td>
                        <a href="/coupons/edit/<?= App\Core\UI::encrypt($coupon['id_coupon']); ?>" type="button"
                            class="btn btn-warning" title="Editar cupom">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#staticBackdropDelete-<?= $coupon['id_coupon']; ?>">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>

                <!-- delete coupon -->
                <div class="modal fade" id="staticBackdropDelete-<?= $coupon['id_coupon']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="coupons/delete/<?=App\Core\UI::encrypt($coupon['id_coupon']); ?>" method="GET">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir Cupom</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h4>Vocẽ tem certeza que deseja deletar esse cupom?</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger fw-bold"><i class="bi bi-trash"></i> Sim, Excluir Cupom</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- delete coupom -->

                <?php
            endforeach;
            ?>
        </tbody>
    </table>
</div>

<?php
    App\Core\UI::partial('footer');
?>

<script>

</script>