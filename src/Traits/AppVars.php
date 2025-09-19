<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.j4starter
 * @author      Mykhailo Kulyk
 * @license     GNU General Public License version 2 or later
 *
 */
declare(strict_types=1);

namespace J4Starter\Traits;


use Exception;
use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;

/**
 * Trait AppVars
 *
 * This trait provides methods to access various application variables and configurations
 * such as user session data, command input values, site metadata, and language properties.
 */
trait AppVars
{

    /**
     * @return CMSApplicationInterface|null
     */
    private static function getApp(): ?CMSApplicationInterface
    {
        try {
            return Factory::getApplication();
        } catch (Exception $exception) {
            Log::add(
                'Application init failed: ' . $exception->getMessage(),
                Log::ERROR,
                'application'
            );
            return null;
        }
    }

    /**
     * @return mixed
     */
    protected function getUser(): mixed
    {
        return self::getApp()?->getSession()->get('user');
    }

    /**
     * Retrieves the 'option' command input value.
     *
     * @return string The value of the 'option' command input, or an empty string if not set.
     */
    protected function getOption(): string
    {
        return self::getApp()?->input->getCmd('option', '') ?? '';
    }


    /**
     * Retrieves the 'view' command input value.
     *
     * @return string The value of the 'view' command input, or an empty string if not set.
     */
    protected function getView(): string
    {
        return self::getApp()?->input->getCmd('view', '') ?? '';
    }

    /**
     * Retrieves the 'layout' command input value.
     *
     * @return string The value of the 'layout' command input, or an empty string if not set.
     */
    protected function getLayout(): string
    {
        return self::getApp()?->input->getCmd('layout', '') ?? '';
    }

    /**
     * Retrieves the 'task' command input value.
     *
     * @return string The value of the 'task' command input, or an empty string if not set.
     */
    protected function getTask(): string
    {
        return self::getApp()?->input->getCmd('task', '') ?? '';
    }

    /**
     * Retrieves the 'Itemid' command input value.
     *
     * @return int|null The value of the 'Itemid' command input as an integer, or null if not set or invalid.
     */
    protected function getItemId(): ?int
    {
        $itemId = self::getApp()->input->getCmd('Itemid');
        return $itemId ? (int)$itemId : null;
    }

    /**
     * Retrieves the site name from the application configuration.
     *
     * @return string The site name escaped for safe output using HTML entities.
     */
    protected function getSiteName(): string
    {
        $siteName = self::getApp()?->get('sitename');
        return $siteName !== null
            ? htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8')
            : '';
    }

    /**
     * Retrieves the page class suffix from the active menu item's parameters.
     *
     * This method uses the application's menu system to determine the currently
     * active menu item and fetches the 'pageclass_sfx' parameter, which is commonly
     * used for styling purposes. If no active menu item is found or the parameter
     * is not set, it returns an empty string.
     *
     * @return string|null The page class suffix or an empty string if not available.
     */
    protected function getPageClass(): ?string
    {
        return self::getApp()?->getMenu()
            ?->getActive()
            ?->getParams()
            ->get('pageclass_sfx', '');
    }

    /**
     * Retrieves the short language tag.
     *
     * This method returns a predefined short language tag string.
     * It is intended to represent the current language in a compact form.
     *
     * @return string The short language tag.
     */
    protected function getLangShortTag(): string
    {
        $langTags = explode('-', self::getApp()?->getLanguage()->getTag());
        return $langTags[0] ?? 'uk';
    }


}