<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

	$app      = JFactory::getApplication();
	$params	  = $app->getTemplate(true)->params;

defined('JPATH_BASE') or die;
?>
			<dd class="published">
				<span class="icon-calendar" aria-hidden="true"></span>
				<time datetime="<?php echo JHtml::_('date', $displayData['item']->publish_up, 'c'); ?>" itemprop="datePublished">
					<?php if ($params->get('specificDateFormat') != "") {
						echo JText::sprintf(JHtml::_('date', $displayData['item']->publish_up, JText::_($params->get('specificDateFormat'))));
					} else {
						echo JText::sprintf(JHtml::_('date', $displayData['item']->publish_up, JText::_('DATE_FORMAT_LC3')));
					}	?>						
				</time>
			</dd>