<?php
declare(ENCODING = 'utf-8');
namespace F3\Blog\RoutePartHandlers;

/*                                                                        *
 * This script belongs to the FLOW3 package "Blog".                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License as published by the Free   *
 * Software Foundation, either version 3 of the License, or (at your      *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        *
 * You should have received a copy of the GNU General Public License      *
 * along with the script.                                                 *
 * If not, see http://www.gnu.org/licenses/gpl.html                       *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Blog route part handler
 *
 * @version $Id$
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
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