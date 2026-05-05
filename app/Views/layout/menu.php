<?php 
$session = session();
$sessionUser = $session->get('username'); // Obtiene el nombre del usuario de la sesión
$menu = $session->get('userMenu'); // Obtiene el nombre del usuario de la sesión
?>

<?php if ($session->get('logged_in')) { ?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">HC - </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMenu" 
            aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav">
            <?php foreach ($menu as $producto => $modulos): ?>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menu_<?= esc($producto) ?>" 
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= esc($producto) ?>
                    </a>
                    <div class="dropdown-menu">
                        <?php foreach ($modulos as $modulo => $transacciones): ?>
                            <h6 class="dropdown-header"><?= esc($modulo) ?></h6>
                            <?php foreach ($transacciones as $transaccion): ?>
                                <a class="dropdown-item" href="javaScript:;" onclick="carga('<?= base_url('empresa/index/'.$transaccion['idProducto'].'-'.$transaccion['idTransaccion'])?>','filtro');">
                                    <?= esc($transaccion['nombre']) ?>
                                </a>                                
                            <?php endforeach; ?>
                            
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </ul>

        <!-- Alineación a la derecha -->
        <ul class="navbar-nav ms-auto">
            <div class="nav-item dropdown dropleft">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i> <?= esc($sessionUser) ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="userDropdown" style="width: 200px;">
                    <a class="dropdown-item" href="<?= base_url('/perfil') ?>">Perfil</a>
                    <div class="dropdown-divider"></div>
                    <?php $empresaLista = session('empresaLista') ?? []; ?>
                    <?php $empresaIdActual = session('empresaId'); ?>

                    <select id="cmbEmpresaPerfil" class="form-control" onchange="cambiarEmpresa(this.value)">
                        <?php foreach ($empresaLista as $empresa): ?>
                            <option value="<?= esc($empresa['IDEMPRESA']) ?>"
                                <?= ($empresaIdActual == $empresa['IDEMPRESA']) ? 'selected' : '' ?>>
                                <?= esc($empresa['NOMEMPRESA']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="<?= base_url('/logout') ?>">
                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                    </a>
                </div>
            </div>
        </ul>
    </div>
</nav>
<?php } ?>