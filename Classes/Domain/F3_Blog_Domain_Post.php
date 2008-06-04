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
 * @subpackage Domain
 * @version $Id$
 */

/**
 * A blog post
 *
 * @package Blog
 * @subpackage Domain
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @entity
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
	 * @var array of F3_Blog_Domain_Tag
	 */
	protected $tags = array();

	/**
	 * @var string
	 */
	protected $author;

	/**
	 * @var string
	 */
	protected $content;

	/**
	 * @var array of F3_Blog_Domain_Comment
	 */
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
	 * @param array $tags One or more F3_Blog_Domain_Tag objects
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setTags(array $tags) {
		$this->tags = $tags;
	}

	/**
	 * Adds a tag to this post
	 *
	 * @param F3_Blog_Domain_Tag $tag
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function addTag(F3_Blog_Domain_Tag $tag) {
		$this->tags[] = $tag;
	}

	/**
	 * Sets the author for this post
	 *
	 * @param string $author
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}

	/**
	 * Sets the content for this post
	 *
	 * @param string $content
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Adds a comment to this post
	 *
	 * @param F3_Blog_Domain_Comment $comment
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function addComment(F3_Blog_Domain_Comment $comment) {
		$this->comments[] = $comment;
	}

	/**
	 * Returns this post as a formatted string
	 *
	 * @return string
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function __toString() {
		return $this->title . chr(10) .
			' written on ' . date_format($this->date, 'Y-m-d') . chr(10) .
			' by ' . $this->author . chr(10) .
			wordwrap($this->content, 70, chr(10)) . chr(10) .
			implode(', ', $this->tags);
	}
}
?>