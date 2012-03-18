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
 *
 * @author Hauke Hain
 * @package Fluidstyledcontent
 * @subpackage ViewHelpers\Data
 */
class Tx_Fluidstyledcontent_ViewHelpers_Data_ContentElementViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	public function initializeArguments() {
		$this->registerArgument('uid', 'integer', 'uid of the Content Element', TRUE);
		$this->registerArgument('fields', 'string', 'List (CSV) of fields that should be returned', FALSE, '*');
		$this->registerArgument('as', 'string', 'Variable name in the template that should contain the content element rows. If not set, the result is returned directly.', FALSE, NULL);
	}

	/**
	 * Render method
	 *
	 * @return array If no 'as' argument is set. Otherwise null (the result is available via the choosen variable name).
	 */
	public function render() {
		$name = $this->arguments['as'];
		$fields = $GLOBALS['TYPO3_DB']->quoteStr ($this->arguments['fields']);
		$ceRow = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow ($fields, 'tt_content', 'uid='.$this->arguments['uid']);
		
		// convert Unix timestamps to DateTime objects
		if ($ceRow['tstamp']) {
			$ceRow['tstamp'] = $this->convertTimestampToDateTime($ceRow['tstamp']);
		}
		if ($ceRow['crdate']) {
			$ceRow['crdate'] = $this->convertTimestampToDateTime($ceRow['crdate']);
		}
		if ($ceRow['starttime']) {
			$ceRow['starttime'] = $this->convertTimestampToDateTime($ceRow['starttime']);
		}
		if ($ceRow['endtime']) {
			$ceRow['endtime'] = $this->convertTimestampToDateTime($ceRow['endtime']);
		}
		if ($ceRow['date']) {
			$ceRow['date'] = $this->convertTimestampToDateTime($ceRow['date']);
		}

		// return "CE"
		if ($name === NULL) {
			return $ceRow;
		} else {
			if ($this->templateVariableContainer->exists($name)) {
				$this->templateVariableContainer->remove($name);
			}
			$this->templateVariableContainer->add($name, $ceRow);
		}
	}
	
	/**
	 * Converts a Unix timestamp into a DateTime object
	 * Respects local timezone setting
	 *
	 * @param integer Unix timestamp
	 * @return DateTime
	 */
	private function convertTimestampToDateTime($ts) {
		$ts = date(DateTime::W3C, $ts); // respect local timezone
		$converter = new Tx_Extbase_Property_TypeConverter_DateTimeConverter();
		$ts = $converter->convertFrom($ts, 'DateTime');
		
		return $ts;
	}

}

?>