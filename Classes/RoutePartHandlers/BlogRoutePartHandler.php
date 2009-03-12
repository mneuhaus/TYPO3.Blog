<?php
declare(ENCODING = 'utf-8');
namespace F3\Blog\RoutePartHandlers;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * @package FLOW3
 * @subpackage MVC
 * @version $Id$
 */

/**
 * Blog route part handler
 *
 * @package FLOW3
 * @subpackage MVC
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 */
class BlogRoutePartHandler extends \F3\FLOW3\MVC\Web\Routing\DynamicRoutePart {

	/**
	 * While matching, converts the blog title into an identifer array
	 *
	 * @param string $value value to match, the blog title
	 * @return boolean TRUE if value could be matched successfully, otherwise FALSE.
	 * @author Robert Lemke <robert@typo3.org>
	 */
	protected function matchValue($value) {
		if ($value === NULL || $value === '') return FALSE;
		$this->value = array('__identity' => array('name' => $value));
		return TRUE;
	}

	/**
	 * Resolves the name of the blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $value The Blog object
	 * @return boolean TRUE if the name of the blog could be resolved and stored in $this->value, otherwise FALSE.
	 * @author Robert Lemke <robert@typo3.org>
	 */
	protected function resolveValue($value) {
		if (!$value instanceof \F3\Blog\Domain\Model\Blog) return FALSE;
		$this->value = $value->getName();
		return TRUE;
	}
}
?>