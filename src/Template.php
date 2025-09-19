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

use Joomla\CMS\Router\Route;
use JUri;
use Exception;
use JPluginHelper;
use JRegistry;
use RuntimeException;
use JComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;
use J4Starter\Traits\AppVars;
use Joomla\CMS\Document\HtmlDocument;
use Joomla\Registry\Registry;

/**
 * Class Helper
 *
 * A utility class providing methods for generating HTML attributes and determining localized home URLs.
 *
 */
final class Template
{

    /** @var HtmlDocument */
    protected HtmlDocument $document;


    /** @var Registry */
    public Registry $params;


    use AppVars;


    /**
     * @param HtmlDocument $document
     */
    public function __construct(HtmlDocument $document)
    {
        $this->document = $document;
        $this->params = $this->document->params;
    }


    /**
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function get(string $method, array $args = []): mixed
    {
        $method = 'get' . str_replace(["_", "."], "", $method);
        return $this->$method($args);
    }


    /**
     * @return string
     */
    protected function getLanguage(): string
    {
        return $this->document->language;
    }

    /**
     * @return string
     */
    protected function getDirection(): string
    {
        return $this->document->direction;
    }

    /**
     * @return string|null
     */
    protected function getBodyAttributes(): string|null
    {
        return $this->setAttributes([
            'class' => $this->getPageClass(),
            'data-id' => $this->getItemId(),
            'data-lang' => $this->getLangShortTag(),
        ]);
    }


    /**
     * Converts an associative array of attributes into a formatted string for use in HTML elements.
     *
     * @param array $attributes An associative array where the keys are attribute names and the values are attribute values. Empty or invalid attributes will be filtered out.
     * @return string|null A string containing the formatted HTML attributes or null if the input array is empty or contains no valid attributes.
     */
    protected function setAttributes(array $attributes = []): string|null
    {
        $result = null;
        $attributes = array_filter($attributes);
        foreach ($attributes as $name => $value) {
            $result .= " " . $name . '="' . htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') . '"';
        }

        return $result !== null ? trim($result) : null;
    }

    /**
     * Retrieves the home URL based on the system language settings and language filter configurations.
     *
     * This method determines the appropriate home URL for the application, considering the currently active language,
     * the default site language, and the plugin settings for language handling. If the "remove_default_prefix" option
     * is enabled and the active language matches the default site language, the base URL is returned without a language prefix.
     * Otherwise, a language-specific prefix is appended to the base URL.
     *
     * @return string The generated home URL, potentially including a language-specific prefix if applicable.
     * @throws RuntimeException If an error occurs during URL generation due to an exception being thrown.
     */

    protected function getHomeUrl(): string
    {
        try {
            $app = Factory::getApplication();
            $lang = $app?->getLanguage();
            /** @var string $siteLang */
            $siteLang = JComponentHelper::getParams('com_languages')->get('site');
            $plugin = JPluginHelper::getPlugin('system', 'languagefilter');

            if (empty($plugin)) {
                return JUri::base();
            }

            $params = new JRegistry($plugin->params);
            if ($params->get('remove_default_prefix') === 1 && $lang->getTag() === $siteLang) {
                return JUri::base();
            }
            // Lang Code
            $shortCodeLang = null;
            $langTag = explode('-', $lang->getTag());
            if (isset($langTag[0])) {
                $shortCodeLang = $langTag[0] . DIRECTORY_SEPARATOR;
            }
            return Route::_("index.php?lang=$shortCodeLang", true, Route::TLS_IGNORE, true);
        } catch (Exception $exception) {
            Log::add(
                ': ' . $exception->getMessage(),
                Log::ERROR,
                'method'
            );
            throw new RuntimeException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

}