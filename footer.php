<?php

/**
 * Footer component
 * 
 * This file is part of the OSIRIS package.
 * Copyright (c) 2023, Julia Koblitz
 *
 * @package     OSIRIS
 * @since       1.0.0
 * 
 * @copyright	Copyright (c) 2023, Julia Koblitz
 * @author		Julia Koblitz <julia.koblitz@dsmz.de>
 * @license     MIT
 */
?>

</div>

<footer class="page-footer">

    <div class="link-parade">
        <div class="row">
            <div class="col">
                <h3 class="title">
                    News & Help
                </h3>

                <a href="<?= ROOTPATH ?>/new-stuff" class="">
                    <?= lang('News', 'Neuigkeiten') ?>
                </a>

                <a href="<?= ROOTPATH ?>/docs" class="">
                    <?= lang('Documentation', 'Dokumentation') ?>
                </a>

                <a href="https://github.com/JKoblitz/osiris/issues" target="_blank" class="">
                    <?= lang('Report an issue', "Problem melden") ?>
                    <i class="ph ph-arrow-square-out"></i>
                </a>
            </div>
            <div class="col">
                <h3>OSIRIS</h3>
                <a href="<?= ROOTPATH ?>/about" class="">
                    <?= lang('About OSIRIS', 'Über OSIRIS') ?>
                </a>
                <a href="https://osiris-app.de" target="_blank" class="">
                    osiris-app.de
                    <i class="ph ph-arrow-square-out"></i>
                </a>
                <p>
                    <?= lang('OSIRIS is developed with', 'OSIRIS wird mit') ?> <i class="ph ph-heart" title="Für Leonie"></i> in Helmstedt<?= lang('.', ' entwickelt.') ?>
                </p>
            </div>
            <div class="col">
                <h3>Imprint</h3>

                <a href="<?= ROOTPATH ?>/impress"><?= lang('Impress', 'Impressum') ?></a>
                <a href="<?= ROOTPATH ?>/license"><?= lang('License', 'Lizenz') ?></a>
                <p>
                    &copy; Julia Koblitz 2023
                </p>
            </div>
        </div>
    </div>

</footer>


</div>
<!-- Content wrapper end -->

</div>
<!-- Page wrapper end -->

</body>

</html>