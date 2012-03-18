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
 * RenderContentElements Widget Controller
 *
 * @author Hauke Hain
 * @package Fluidstyledcontent
 * @subpackage ViewHelpers/Widget
 */
class Tx_Fluidstyledcontent_ViewHelpers_Widget_Controller_RenderContentElementsController extends Tx_Fluid_Core_Widget_AbstractWidgetController {

	/**
	 * @var array
	 */
	protected $contentElements;

	/**
	 * Initialize action
	 */
	public function initializeAction() {
		$this->contentElements = $this->getContentElements();
	}

	/**
	 * @return string
	 */
	public function indexAction() {
		$this->view->assign('contentElements', $this->contentElements);
		return $this->view->render();
	}

	/**
	 * Get content elements based on column and pid and return them as an array
	 *
	 * @author Claus Due, Wildside A/S
	 * @author Daniel Schöne, schoene.it (added "slide" feature)
	 * @author Hauke Hain (render content elements with fluid)
	 * @return array
	 */
	protected function getContentElements() {
		$pid = $this->widgetConfiguration['pageUid'] ? $this->widgetConfiguration['pageUid'] : $GLOBALS['TSFE']->id;
		$order = $this->widgetConfiguration['order'] . ' ' . $this->widgetConfiguration['sortDirection'];
		$colPos = $this->widgetConfiguration['column'];
		$slide = $this->widgetConfiguration['slide'] ? $this->widgetConfiguration['slide'] : FALSE;
		$slideCollect = $this->widgetConfiguration['slideCollect'] ? $this->widgetConfiguration['slideCollect'] : FALSE;
		if($slideCollect !== FALSE){
			$slide = min($slide, $slideCollect);
		}
		$slideCollectReverse = $this->widgetConfiguration['slideCollectReverse'];
		$rootLine = NULL;
		if($slide){
			$pageSelect = new t3lib_pageSelect();
			$rootLine = $pageSelect->getRootLine($pid);
			if($slideCollectReverse){
				$rootLine = array_reverse($rootLine);
			}
		}

		$ceArr = array();
		do {
			if ($slide){
				$page = array_shift($rootLine);
				if (!$page){
					break;
				}
				$pid = $page['uid'];
			}
			$conditions = "pid = '" . $pid ."' AND colPos = '" . $colPos . "' AND tx_flux_column = '' " . $GLOBALS['TSFE']->cObj->enableFields('tt_content') .  " AND (sys_language_uid IN (-1,0) OR (sys_language_uid = '" . $GLOBALS['TSFE']->sys_language_uid . "' AND l18n_parent = '0'))";
			$ceArr = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid, ctype', 'tt_content', $conditions, 'uid', $order, $this->widgetConfiguration['limit']);
			#debugster($rows); 
			if (count($ceArr) && !$slideCollect){
				break;
			}
		} while($slide !== FALSE && --$slide !== -1);

		return $ceArr;
	}
}

?>