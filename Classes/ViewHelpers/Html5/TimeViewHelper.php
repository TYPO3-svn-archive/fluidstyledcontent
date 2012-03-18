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
 * ************************************************************* */

/**
 * HTML5 TimeViewHelper
 *
 * Renders a time tag.
 * 
 * Example: <fsc:html5.time date="{dateObject}" format="Y-m-d" />
 *
 * @author Hauke Hain
 * @package Fluidstyledcontent
 * @subpackage ViewHelpers/HTML5
 */
class Tx_Fluidstyledcontent_ViewHelpers_Html5_TimeViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper {

	/**
	 * @var string
	 */
	protected $tagName = 'time';

	/**
	 * Initialize
	 */
	public function initializeArguments() {
		$this->registerArgument('date', 'DateTime', 'The DateTime object that should be rendered', TRUE);
		$this->registerArgument('dateOnly', 'boolean', 'Wheather the datetime attribute should contain only the date, not the complete DateTime.', FALSE);
		$this->registerArgument('format', 'string', 'How to format the date for the visible output.', FALSE, 'Y-m-d H:i:s');
		$this->registerArgument('dateValue', 'string', 'If set the given string will be wrapped by the time tag. No DateTime value will be visible the user, only the given string.', FALSE);
	}

	/**
	 * Renders the time tag
	 *
	 * @return string
	 */
	public function render() {
		if ($this->arguments['dateOnly']) {
			$this->tag->addAttribute('datetime', $this->arguments['date']->format('Y-m-d'));
		} else {
			$this->tag->addAttribute('datetime', $this->arguments['date']->format('c'));
		}

		if ($this->arguments['dateValue']) {
			$this->tag->setContent($this->arguments['dateValue']);
		} else {
			$this->tag->setContent($this->arguments['date']->format($this->arguments['format']));
		}

		return $this->tag->render();
	}

}

?>