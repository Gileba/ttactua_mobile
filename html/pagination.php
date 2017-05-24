<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Renders an active item in the pagination block
 *
 * @param   JPaginationObject  $item  The current pagination object
 *
 * @return  string                    HTML markup for active item
 *
 * @since   3.0
 */
function pagination_item_active(&$item)
{
	$class = '';

	// Check for "Start" item
	if ($item->text == JText::_('JLIB_HTML_START'))
	{
		$display = '<span class="icon-first"></span>';
	}

	// Check for "Prev" item
	if ($item->text == JText::_('JPREV'))
	{
		$display = '<span class="icon-previous"></span>';
	}

	// Check for "Next" item
	if ($item->text == JText::_('JNEXT'))
	{
		$display = '<span class="icon-next"></span>';
	}

	// Check for "End" item
	if ($item->text == JText::_('JLIB_HTML_END'))
	{
		$display = '<span class="icon-last"></span>';
	}

	// If the display object isn't set already, just render the item with its text
	if (!isset($display))
	{
		$display = $item->text;
		$class   = ' class="hidden-phone"';
	}

	return '<li' . $class . '><a title="' . $item->text . '" href="' . $item->link . '" class="pagenav">' . $display . '</a></li>';
}

/**
 * Renders an inactive item in the pagination block
 *
 * @param   JPaginationObject  $item  The current pagination object
 *
 * @return  string  HTML markup for inactive item
 *
 * @since   3.0
 */
function pagination_item_inactive(&$item)
{
	// Check for "Start" item
	if ($item->text == JText::_('JLIB_HTML_START'))
	{
		return '<li class="disabled"><a><span class="icon-first"></span></a></li>';
	}

	// Check for "Prev" item
	if ($item->text == JText::_('JPREV'))
	{
		return '<li class="disabled"><a><span class="icon-previous"></span></a></li>';
	}

	// Check for "Next" item
	if ($item->text == JText::_('JNEXT'))
	{
		return '<li class="disabled"><a><span class="icon-next"></span></a></li>';
	}

	// Check for "End" item
	if ($item->text == JText::_('JLIB_HTML_END'))
	{
		return '<li class="disabled"><a><span class="icon-last"></span></a></li>';
	}

	// Check if the item is the active page
	if (isset($item->active) && $item->active)
	{
		return '<li class="active hidden-phone"><span class="pagenav">' . $item->text . '</span></li>';
	}

	// Doesn't match any other condition, render a normal item
	return '<li class="disabled hidden-phone"><a>' . $item->text . '</a></li>';
}

/**
 * By default joomla display 10 pages in pagination. This file allows
 * us to customize the number of displayed pages.
 * 
 * Simply add this file to $template/html/pagination.php and
 * change $displayedPages variable.
 */

/**
 * Override joomla default pagination list render method
 * @param  array	$list	Pagination raw data
 * @return string			HTML string
 */
function pagination_list_render($list) {
	$displayedPages = 6;
	// Reduce number of displayed pages to 6 instead of 10
	$list['pages'] = _reduce_displayed_pages($list['pages'], $displayedPages);
	return _list_render($list);
}
/**
 * Reduce number of displayed pages in pagination
 * @param  array	$pages			Pagination pages raw data
 * @param  integer	$displayedPages	Number of displayed pages
 * @return string					HTML string
 */
function _reduce_displayed_pages($pages, $displayedPages) {
	$currentPageIndex = _get_current_page_index($pages);
	$midPoint = ceil($displayedPages / 2);
	if ($currentPageIndex >= $displayedPages) {
		$pages = array_slice($pages, -$displayedPages);
		return $pages;
	} 
	
	$startIndex = max($currentPageIndex - $midPoint, 0); 	
	$pages = array_slice($pages, $startIndex, $displayedPages);
	
	return $pages;
}
/**
 * Get current page index
 * @param  array	$pages	Pagination pages raw data
 * @return integer			Current page index
 */
function _get_current_page_index($pages) {
	$counter = 0;
	foreach ($pages as $page) {
		if (!$page['active']) return $counter;
		$counter++;
	}
}
/**
 * Function copied from joomla html pagination to render pagination data into html string
 * @param  array	$list	Pagination raw data
 * @return string			HTML string
 */
function _list_render($list) {
	// Reverse output rendering for right-to-left display.
	$html = '<ul>';
	$html .= '<li class="pagination-start">' . $list['start']['data'] . '</li>';
	$html .= '<li class="pagination-prev">' . $list['previous']['data'] . '</li>';
	foreach ($list['pages'] as $page)
	{
		$html .= '<li>' . $page['data'] . '</li>';
	}
	$html .= '<li class="pagination-next">' . $list['next']['data'] . '</li>';
	$html .= '<li class="pagination-end">' . $list['end']['data'] . '</li>';
	$html .= '</ul>';
	return $html;
}
