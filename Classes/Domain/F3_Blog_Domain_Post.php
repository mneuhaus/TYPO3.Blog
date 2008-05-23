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
 * @package
 * @subpackage
 * @version $Id$
 */

/**
 *
 *
 * @package
 * @subpackage
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class F3_Blog_Domain_Post {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var DateTime
	 */
	protected $date;

	/**
	 * @var array of F3_Blog_Domain_Post
	 */
	protected $tags = array();

	/**
	 * @var string(45)
	 */
	protected $author;
	protected $content;
	protected $comments = array();

	/**
	 * Setter for title
	 *
	 * @param string $title
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Setter for date
	 *
	 * @param string $date
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	 * Setter for tags
	 *
	 * @param string $tags
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setTags($tags) {
		$this->tags = $tags;
	}

	/**
	 * Enter description here...
	 *
	 * @param F3_Blog_Domain_Comment $comment
	 */
	public function addComment(F3_Blog_Domain_Comment $comment) {
		$this->comments[] = $comment;
	}
}
?>