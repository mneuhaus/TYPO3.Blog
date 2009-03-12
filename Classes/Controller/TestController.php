<?php
declare(ENCODING = 'utf-8');
namespace F3\Blog\Controller;

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
 * @package Blog
 * @subpackage Controller
 * @version $Id$
 */

/**
 *
 *
 * @package Blog
 * @subpackage Controller
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class TestController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * Index action for this controller. Displays a list of blogs.
	 *
	 * @param string $foo
	 * @param \ArrayObject $bar
	 * @return string The rendered view
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function indexAction($foo, \ArrayObject $bar, $baz = '') {
		var_dump($foo);
		var_dump($bar);
	}
}

?>