<?php

$ubic = $ubic_det ?? '';
$_indexc = '';
$_campos = $config->r_camposdet ?? [];
$botos   = $config->r_boto ?? [];

$_dato = explode("|", $config->r_dato ?? '');
$dato  = $_dato[0] ?? '';

if (!is_array($_campos) || empty($_campos)) {
    echo '<p>No existen configuraciones de detalle.</p>';
    return;
}

$count = count($_campos);

for ($r = 0; $r < $count; $r++) {

    $param  = $_campos[$r]['prm'] ?? '';
    $campos = $_campos[$r]['cmp'] ?? [];
    $accion = 'con';

    // índice cabecera para crear nuevo detalle
    $_indexc = '';
    if (isset($id[$r]) && is_array($id[$r])) {
        foreach ($id[$r] as $key => $rdo) {
            $_indexc .= $rdo . '--';
        }
    }

    // nueva estructura
    $bloqueDetalle = $emp[$r] ?? [];
    $tablaDetalle  = $bloqueDetalle['tabla'] ?? '';
    $registros     = $bloqueDetalle['datos'] ?? [];

    $i = 0;
?>

<?php if (!empty($registros) && is_array($registros)) : ?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">

        <table class="display dt-detalle" id="detTable_<?= $r ?>">
            <thead>
                <tr>
                    <th width="10">No</th>
                    <?php foreach ($campos as $campo) : ?>
                        <?php
                        $lista = explode("|", $campo['lst'] ?? '');
                        if (($lista[0] ?? '0') == '1') :
                        ?>
                            <th data-sortable="true"><?= esc($campo['as'] ?? '') ?></th>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <th width="30"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $em) : ?>
                    <?php
                    $i++;
                    $_index = $em['_INDEX'] ?? '';
                    ?>
                    <tr id="tr_<?= $r ?>_<?= $i ?>">
                        <td><?= $i; ?></td>

                        <?php foreach ($campos as $campo) : ?>
                            <?php
                            $lista = explode("|", $campo['lst'] ?? '');
                            if (($lista[0] ?? '0') == '1') :
                                $nombreCampo = strtoupper($campo['campo'] ?? '');
                            ?>
                                <td><?= esc($em[$nombreCampo] ?? '') ?></td>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <td>
                            <a href="javascript:;"
                               onclick="add_person('N','N');carga('<?= base_url() ?>empresa/actualizar/<?= $dato . '/' . $i . '/' . $_index . '/D/' . $r . '/' . $ubic ?>','contenidom');"
                               id="lnk_act">a</a>

                            <a href="javascript:;"
                               onclick="if (eliminar()== true) { carga('<?= base_url() ?>empresa/eliminar/<?= $dato . '/' . $i . '/' . $_index . '/D/' . $r . '/' . $ubic ?>','filtro');}"
                               id="lnk_eli">e</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <?php foreach ($campos as $campo) : ?>
                        <?php
                        $lista = explode("|", $campo['lst'] ?? '');
                        if (($lista[0] ?? '0') == '1') :
                        ?>
                            <th></th>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>
    <div class="col-md-2"></div>
</div>
<?php else : ?>
    <p>No existen Registros</p>
<?php endif; ?>

<ul>
    <li>
        <a href="javascript:;"
           onclick="add_person();carga('<?= base_url() ?>empresa/nuevo/<?= $dato . '/0/' . $_indexc . '/D/' . $r . '/' . $ubic ?>','contenidom');"
           class="lnk_btn">
            Crear Registro
        </a>
    </li>
</ul>

<?php } ?>
<?php  exit; ?>