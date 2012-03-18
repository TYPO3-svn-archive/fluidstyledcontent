<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Hauke Hain <hhpreuss@googlemail.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * RenderContentElements Widget
 *
 * A simple ViewHelper that returns all ContentElements that meet the conditions (arguments)
 * The template is used to render the different kind of ContentElements
 *
 * @author Hauke Hain
 * @package Fluidstyledcontent
 * @subpackage ViewHelpers/Widget
 */
class Tx_Fluidstyledcontent_ViewHelpers_Widget_RenderContentElementsViewHelper extends Tx_Fluid_Core_Widget_AbstractWidgetViewHelper {

	/**
	 * @var Tx_Fluidstyledcontent_ViewHelpers_Widget_Controller_RenderContentElementsController
	 */
	protected $controller;

	/**
	 * @param Tx_Fluidstyledcontent_ViewHelpers_Widget_Controller_RenderContentElementsController $controller
	 */
	public function injectController(Tx_Fluidstyledcontent_ViewHelpers_Widget_Controller_RenderContentElementsController $controller) {
		$this->controller = $controller;
	}

	/**
	 * Initialize
	 */
	public function initializeArguments() {
		$this->registerArgument('pageUid', 'integer', 'If set, gets content from this page');
		$this->registerArgument('column', 'integer', 'Name of the column to render', FALSE, 0);
		$this->registerArgument('limit', 'integer', 'Optional limit to the number of content elements to render');
		$this->registerArgument('order', 'string', 'Optional sort field of content elements - RAND() supported', FALSE, 'sorting');
		$this->registerArgument('sortDirection', 'string', 'Optional sort direction of content elements', FALSE, 'ASC');
		$this->registerArgument('slide', 'integer', 'Enables Content Sliding - amount of levels which shall get walked up the rootline. For infinite sliding (till the rootpage) set to -1)', FALSE, 0);
		$this->registerArgument('slideCollect', 'integer', 'Enables collecting of Content Elements - amount of levels which shall get walked up the rootline. For infinite sliding (till the rootpage) set to -1 (lesser value for slide and slide.collect applies))', FALSE, 0);
		$this->registerArgument('slideCollectReverse', 'boolean', 'Normally when collecting content elements the elements from the actual page get shown on the top and those from the parent pages below those. You can invert this behaviour (actual page elements at bottom) by setting this flag))', FALSE, 0);
	}

	/**
	 * Render
	 */
	public function render() {
		return $this->initiateSubRequest();
	}

}

?>