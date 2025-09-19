<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.j4starter
 * @author      Mykhailo Kulyk
 * @license     GNU General Public License version 2 or later
 *
 */
defined('_JEXEC') or die;

require_once __DIR__ . '/config/config.php';

use J4Starter\Template;

/** @var Template $template */
?>
<!DOCTYPE html>
<html lang="<?= $template->get('language') ?>" dir="<?= $template->get('direction') ?>">
<head>
    <jdoc:include type="metas"/>
    <jdoc:include type="styles"/>
    <?= $template->params->get('header_code') ?>
</head>
<body <?= $template->get('body_attributes') ?>>
<div id="wrapper">

    <div id="slideout-panel">
        <div class="container">

            <header>
                <div class="row">
                    <div class="col">
                        <a href="<?= $template->get('home_url') ?>"><?= $template->get('site_name') ?></a>
                    </div>
                    <div class="col-auto">
                        <nav>
                            <a href="#" class="toggle-button">
                                <i class="fa-solid fa-bars-staggered"></i>
                            </a>
                        </nav>
                    </div>
                </div>
            </header>

            <main>
                <div class="row">
                    <div class="col">

                    </div>
                </div>
            </main>

            <footer>
                <div class="row">
                    <div class="col">

                    </div>
                </div>
            </footer>
        </div>

    </div>
</div>

<div id="panel">

</div>
<jdoc:include type="scripts"/>
<?= $template->params->get('footer_code') ?>
<jdoc:include type="modules" name="debug" style="none"/>
</body>
</html>

