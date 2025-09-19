<?php
/**
 * @package         Joomla.Site
 * @subpackage      mod_breadcrumbs
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license         GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\WebAsset\WebAssetManager;

/** @var object $module */
/** @var object $params */
/** @var object $app */

?>
<nav class="mod-breadcrumbs__wrapper" aria-label="<?php echo htmlspecialchars($module->title, ENT_QUOTES, 'UTF-8'); ?>">
	<ol class="mod-breadcrumbs breadcrumb px-3 py-2">
		<?php if ($params->get('showHere', 1)) : ?>
			<li class="mod-breadcrumbs__here float-start">
				<?php echo Text::_('MOD_BREADCRUMBS_HERE'); ?>&#160;
			</li>
		<?php endif; ?>

		<?php
		// Get rid of duplicated entries on trail including home page when using multilanguage
		$count = 0;
		for ($i = 0; $i < $count; $i++)
		{
			if ($i === 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link === $list[$i - 1]->link)
			{
				unset($list[$i]);
			}
		}

		// Find last and penultimate items in breadcrumbs list
		end($list);
		$last_item_key = key($list);
		prev($list);
		$penult_item_key = key($list);

		// Make a link if not the last item in the breadcrumbs
		$show_last = $params->get('showLast', 1);

		$class = null;

		// Generate the trail
		foreach ($list as $key => $item) :

			$link = $item->link !== '' ? $item->link : JUri::current();

			$breadcrumbItem = '';
			if ($key === 0)
			{
				$breadcrumbItem .= '<i class="fas fa-light fa-tooth"></i>';
			}

			$breadcrumbItem .= HTMLHelper::_('link', Route::_($link), '<span>' . $item->name . '</span>', ['class' => 'pathway']);

			echo '<li class="mod-breadcrumbs__item breadcrumb-item' . $class . '">' . $breadcrumbItem . '</li>';
		endforeach; ?>
	</ol>
	<?php

	// Structured data as JSON
	$data = [
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => []
	];



	foreach ($list as $key => $item)
	{
		$link = $item->link !== '' ? $item->link : JUri::current();
		$data['itemListElement'][] = [
			'@type'    => 'ListItem',
			'position' => $key + 1,
			'item'     => [
				'@id'  => Route::_($link, true, Route::TLS_IGNORE, true),
				'name' => $item->name
			]
		];
	}

	/** @var WebAssetManager $wa */
	$wa = $app->getDocument()->getWebAssetManager();
	try
	{
		$wa->addInline('script', json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), [], ['type' => 'application/ld+json']);
	}
	catch (JsonException $e)
	{
	}
	?>
</nav>
