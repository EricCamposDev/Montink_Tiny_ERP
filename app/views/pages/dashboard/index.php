<?php
    App\Core\UI::partial('header');
    App\Core\Notify::show();
?>

<div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">Visão Geral</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Produtos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Pedidos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Cupons</a>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Conteúdo principal -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Visão Geral</h1>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="card text-bg-primary mb-3">
              <div class="card-body">
                <h5 class="card-title">Total de Produtos</h5>
                <p class="card-text">120</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-bg-success mb-3">
              <div class="card-body">
                <h5 class="card-title">Pedidos Recentes</h5>
                <p class="card-text">35</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-bg-warning mb-3">
              <div class="card-body">
                <h5 class="card-title">Cupons Ativos</h5>
                <p class="card-text">8</p>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

<?php
    App\Core\UI::partial('footer'); 
?>