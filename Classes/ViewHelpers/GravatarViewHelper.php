<?php
declare(ENCODING = 'utf-8');
namespace F3\Blog\ViewHelpers;

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
 * @package
 * @subpackage
 * @version $Id:$
 */
/**
 * [Enter description here]
 *
 * @package
 * @subpackage
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 */
class GravatarViewHelper extends \F3\Fluid\Core\ViewHelper\TagBasedViewHelper {
	/**
	 * Initialize arguments
	 *
	 * @return void
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function initializeArguments() {
		$this->registerArgument('email', 'string', 'Gravatar Email', TRUE);
		$this->registerArgument('default', 'string', 'Default URL if no gravatar was found');
		$this->registerArgument('size', 'Integer', 'Size of the gravatar');

		$this->registerUniversalTagAttributes();
	}

	/**
	 * Render the link.
	 *
	 * @return string The rendered link
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function render() {
		$baseURI = $this->variableContainer->get('view')->getRequest()->getBaseURI();
		$gravatarURI = 'http://www.gravatar.com/avatar/' . md5((string)$this->arguments['email']);
		$uriParts = array();
		if ($this->arguments['default']) {
			$uriParts[] = 'd=' . urlencode($baseURI . $this->arguments['default']);
		}
		if ($this->arguments['size']) {
			$uriParts[] = 's=' . $this->arguments['size'];
		}
		if (count($uriParts)) {
			$gravatarURI .= '?' . implode('&', $uriParts);
		}
		$out = '<img src="' . $gravatarURI . '"' . $this->renderTagAttributes() . ' />';
		return $out;
	}
}


?>