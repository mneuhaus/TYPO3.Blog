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
	 * @var F3_Blog_Domain_Blog
	 */
	protected $blog;

	/**
	 * Sets the model for this view, a Blog
	 *
	 * @param F3_Blog_Domain_Blog $blog The Blog to display the latest entries from
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setBlog(F3_Blog_Domain_Blog $blog) {
		$this->blog = $blog;
	}

	/**
	 * Renders a list of the latest posts
	 *
	 * @return string The HTML to display
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function render() {
		$latestPosts = $this->fetchLatestPosts();

		$HTML = '<html><body><h1>Latest posts</h1>';
		if (count($latestPosts)) {
			foreach ($latestPosts as $post) {
				$HTML .= '<pre>' . (string)$post . '</pre>';
				$HTML .= '<hr />';
			}
		} else {
			$HTML .= '<p>None found.</p>';
		}
		$HTML .= '</body></html>';
	}

	/**
	 * Fetches the latest posts from the Blog
	 *
	 * @return array of F3_Blog_Domain_Post
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function fetchLatestPosts() {
		return (array) $this->blog->findMostRecentPosts(5);
	}
}

?>