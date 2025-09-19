<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.j4starter
 * @author      Mykhailo Kulyk
 * @license     GNU General Public License version 2 or later
 *
 */
declare(strict_types=1);

namespace J4Starter;


use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\WebAsset\WebAssetManager;
use JsonException;

/**
 * TemplateAsset is a utility class for managing and disabling and enabling specific
 * scripts and styles in a Joomla web environment.
 */
final class TemplateAsset
{

    /** @var WebAssetManager */
    protected WebAssetManager $webAssetManager;

    /**
     * @param WebAssetManager $webAssetManager
     */
    public function __construct(WebAssetManager $webAssetManager)
    {
        $this->webAssetManager = $webAssetManager;
    }


    /**
     * @throws JsonException
     * @throws Exception
     */
    public function autoload(): TemplateAsset
    {
        $templateName = Factory::getApplication()?->getTemplate() ?? 'j4starter';
        $templatePath = JPATH_SITE . '/templates/' . $templateName . '/joomla.asset.json';
        if (file_exists($templatePath)) {
            $json = file_get_contents($templatePath);
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
            foreach ($data['assets'] as $asset) {
                if (trim($asset['uri']) !== '') {
                    $this->webAssetManager->useAsset($asset['type'], $asset['name']);
                } else {
                    $this->webAssetManager->disableAsset($asset['type'], $asset['name']);
                }
            }
        }
        return $this;
    }

    /**
     * @param array $scripts
     * @return $this
     */
    public function disableScripts(array $scripts): TemplateAsset
    {
        foreach ($scripts as $name) {
            $this->webAssetManager->disableScript($name);
        }
        return $this;
    }

    /**
     * @param array $styles
     * @return $this
     */
    public function disableStyles(array $styles): TemplateAsset
    {
        foreach ($styles as $name) {
            $this->webAssetManager->disableStyle($name);
        }
        return $this;
    }


    /**
     * @param array $scripts
     * @return $this
     */
    public function addScripts(array $scripts): TemplateAsset
    {
        foreach ($scripts as $name) {
            $this->webAssetManager->useScript($name);
        }
        return $this;
    }

    /**
     * @param array $styles
     * @return $this
     */
    public function addStyles(array $styles): TemplateAsset
    {
        foreach ($styles as $name) {
            $this->webAssetManager->useStyle($name);
        }
        return $this;
    }

    /**
     * Disable all standard Joomla scripts/styles you usually want to remove.
     * Only for Joomla 4 and if you do not need default styles or scripts or wish to use your own
     */
    public function disableDefaults(): TemplateAsset
    {
        // Disable jQuery
        $this->disableScripts(['jquery', 'jquery-migrate']);

        // Disable Bootstrap JS parts // 'bootstrap.bundle',
        $this->disableScripts(['bootstrap.es5', 'bootstrap.alert', 'bootstrap.button',
            'bootstrap.carousel', 'bootstrap.dropdown', 'bootstrap.modal', 'bootstrap.offcanvas', 'bootstrap.popover',
            'bootstrap.scrollspy', 'bootstrap.tab', 'bootstrap.toast', 'bootstrap.collapse']);

        // Disable
        $this->disableStyles(['bootstrap.css']);

        // Disable FontAwesome CSS
        $this->disableStyles(['fontawesome']);

        return $this;
    }

}