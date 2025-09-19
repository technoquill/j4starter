<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.j4starter
 * @author      Mykhailo Kulyk
 * @license     GNU General Public License version 2 or later
 *
 */
declare(strict_types=1);

if (!defined('DS'))
{
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * A variable used to define or store a prefix string.
 * This prefix can be used for naming conventions,
 * categorizing data, or pre-pending strings to other values.
 *
 * Use this variable to provide a consistent beginning
 * to identifiers or labels within the application.
 *
 * @var string $prefix
 */
spl_autoload_register(static function (string $class) {

    $prefix = 'J4Starter\\';
    $baseDir = __DIR__ . '/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});










