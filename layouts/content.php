<?php
/** @package     Joomla.Site
 * @subpackage  Templates.
 * @author      Mykhailo Kulyk
 * @license     GNU General Public License version 2 or later
 * @copyright
 */
defined('_JEXEC') or die;

?>

<div class="wrapper-container">
    <div id="content">
        <jdoc:include type="message"/>
        <?php if ($this->countModules('breadcrumbs')) : ?>
            <jdoc:include type="modules" name="breadcrumbs"/>
        <?php endif; ?>
        <?php if ($this->countModules('before_content')) : ?>
            <div id="after-content">
                <jdoc:include type="modules" style="html5" name="before_content"/>
            </div>
        <?php endif; ?>
        <jdoc:include type="component"/>
        <?php if ($this->countModules('after_content')) : ?>
            <div id="after-content">
                <jdoc:include type="modules" style="html5" name="after_content"/>
            </div>
        <?php endif; ?>
    </div>
</div>

