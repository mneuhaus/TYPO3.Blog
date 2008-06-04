<?php
declare(ENCODING = 'utf-8');

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
 * @subpackage View
 * @version $Id$
 */

/**
 * View for displaying the latest posts
 *
 * @package Blog
 * @subpackage View
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class F3_Blog_View_LatestPosts {

	/**
	 * @var array
	 */
	protected $posts = array();

	/**
	 * Sets the model for this view, an array of blog posts
	 *
	 * @param array $posts The blog posts to display
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setPosts(array $posts) {
		$this->posts = $posts;
	}

	/**
	 * Renders a list of the latest posts
	 *
	 * @return string The HTML to display
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function render() {
		$HTML = '<html><body><h1>Latest posts</h1>';
		if (count($this->posts)) {
			foreach ($this->posts as $post) {
				$HTML .= '<pre>' . (string)$post . '</pre>';
				$HTML .= '<hr />';
			}
		} else {
			$HTML .= '<p>None found.</p>';
		}
		$HTML .= '</body></html>';
		return $HTML;
	}

}

?>