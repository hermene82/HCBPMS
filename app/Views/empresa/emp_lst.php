<?php
$_campos = $config->r_campos ?? [];
$botos   = $config->r_boto ?? [];
$botosd  = $config->r_camposbot ?? [];

$campos  = $_campos['cmp'] ?? [];
$btn     = $_campos['btn'] ?? [];

$_dato = explode('|', $config->r_dato ?? '');
$dato  = $_dato[0] ?? '';

$i = 0;
?>

<?php if (!empty($botosd) && is_array($botosd)) : ?>
    <?php $ir = 0; ?>
    <?php foreach ($botosd as $bot) : ?>
        <?php
        $bcampos   = $bot['cmp'] ?? [];
        $bbtn      = $bot['btn'] ?? [];
        $bbtnn     = $bot['btnn'] ?? '1';
        $tablaBot  = $bot['tabla'] ?? '';
        $tablaData = $bemp[$ir]['tabla'] ?? '';
        $detalle   = $bemp[$ir]['datos'] ?? [];

        // Si el bloque no corresponde a la tabla esperada, no mostrar registros
        if ($tablaBot !== $tablaData) {
            $detalle = [];
        }
        ?>
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                <?= esc($bot['title'] ?? '') ?>
            </button>

            <div class="dropdown-menu p-2" style="min-width: 900px;">
                <?php if (!empty($detalle) && is_array($detalle)) : ?>
                    <table cellpadding="0" cellspacing="0" border="0" class="display dt-boton">
                        <thead>
                            <tr>
                                <th width="10"></th>
                                <th width="10">No</th>
                                <?php foreach ($bcampos as $campo) : ?>
                                    <?php
                                    $lista = explode('|', $campo['lst'] ?? '');
                                    if (($lista[0] ?? '0') == '1') :
                                    ?>
                                        <th><?= esc($campo['as'] ?? '') ?></th>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <th width="30"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $j = 0; ?>
                            <?php foreach ($detalle as $em) : ?>
                                <?php
                                $j++;
                                $_index = $em['_INDEX'] ?? '';
                                ?>
                                <tr>
                                    <td></td>
                                    <th><?= $j ?></th>

                                    <?php foreach ($bcampos as $campo) : ?>
                                        <?php
                                        $lista = explode('|', $campo['lst'] ?? '');
                                        if (($lista[0] ?? '0') == '1') :
                                            $nombreCampo = strtoupper($campo['campo'] ?? '');
                                        ?>
                                            <td><?= esc($em[$nombreCampo] ?? '') ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                    <td>
                                        <?php if (!empty($bbtn) && is_array($bbtn)) : ?>
                                            <?php foreach ($bbtn as $bt) : ?>
                                                <a
                                                    title="<?= esc($bt['title'] ?? '') ?>"
                                                    href="javascript:;"
                                                    onclick="<?= ($bt['procesoa'] ?? '') . $dato . '/' . $j . '/' . $_index . '/B/' . $ir . ($bt['procesob'] ?? '') ?>"
                                                    id="<?= esc($bt['id'] ?? '') ?>"
                                                >
                                                    <?= esc($bt['men'] ?? '') ?>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No existen Registros</p>
                <?php endif; ?>

                <?php if ($bbtnn === '1') : ?>
                    <a
                        href="javascript:;"                        
					    onclick="add_person();carga('<?= base_url() ?>empresa/nuevo/<?= $dato.'/0/'.$_index.'/B/'.$ir ?>','contenidom');"
                        class="lnk_btn"
                    >
                        Crear Registro
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php $ir++; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($emp) && is_array($emp)) : ?>
    <table cellpadding="0" cellspacing="0" border="0" class="display dt-main" >
        <thead>
            <tr>
                <th width="10"></th>
                <th width="10">No</th>
                <?php foreach ($campos as $campo) : ?>
                    <?php
                    $lista = explode('|', $campo['lst'] ?? '');
                    if (($lista[0] ?? '0') == '1') :
                    ?>
                        <th><?= esc($campo['as'] ?? '') ?></th>
                    <?php endif; ?>
                <?php endforeach; ?>
                <th width="30"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            <?php foreach ($emp[0]['datos'] as $em) : ?>
                <?php
                $i++;
                $_index = $em['_INDEX'] ?? '';
                ?>
                <tr id="tr_<?= $i ?>">
                    <td class="details-control">
                        <a
                            href="javascript:;"
                            onclick="cargadet('<?= base_url() ?>empresa/detalle/<?= $dato . '/' . $i . '/' . $_index ?>','contenido','<?= $i - 1 ?>');"
                            id="lnk_det"
                        >
                            d
                        </a>
                    </td>

                    <th><?= $i ?></th>

                    <?php foreach ($campos as $campo) : ?>
                        <?php
                        $lista = explode('|', $campo['lst'] ?? '');
                        if (($lista[0] ?? '0') == '1') :
                            $nombreCampo = strtoupper($campo['campo'] ?? '');
                        ?>
                            <td><?= esc($em[$nombreCampo] ?? '') ?></td>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <td>
                        <?php if (!empty($btn) && is_array($btn)) : ?>
                            <?php foreach ($btn as $bt) : ?>
                                <a
                                    title="<?= esc($bt['title'] ?? '') ?>"
                                    href="javascript:;"
                                    onclick="<?= ($bt['procesoa'] ?? '') . $dato . '/' . $i . '/' . $_index . ($bt['procesob'] ?? '') ?>"
                                    id="<?= esc($bt['id'] ?? '') ?>"
                                >
                                    <?= esc($bt['men'] ?? '') ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <?php foreach ($campos as $campo) : ?>
                    <?php
                    $lista = explode('|', $campo['lst'] ?? '');
                    if (($lista[0] ?? '0') == '1') :
                    ?>
                        <th></th>
                    <?php endif; ?>
                <?php endforeach; ?>
                <th></th>
            </tr>
        </tfoot>
    </table>
<?php else : ?>
    <p>No existen Registros</p>
<?php endif; ?>

<ul>
    <li>
        <a
            href="javascript:;"
            onclick="add_person();carga('<?= base_url() ?>empresa/nuevo/<?= $dato ?>','contenidom');"
            class="lnk_btn"
        >
            Crear Registro
        </a>
    </li>
</ul>
<?php  exit; ?>