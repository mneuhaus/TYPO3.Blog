<?php
declare(ENCODING = 'utf-8');
namespace F3\Blog\Domain\Model;

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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @scope prototype
 * @entity
 */
class Post {

	/**
	 * @var \F3\Blog\Domain\Model\Blog
	 * @identity
	 */
	protected $blog;

	/**
	 * @var string
	 * @identity
	 */
	protected $title;

	/**
	 * @var \DateTime
	 * @identity
	 */
	protected $date;

	/**
	 * @var array
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
	 * @var integer
	 */
	protected $votes = 0;

	/**
	 * @var array
	 */
	protected $comments = array();

	/**
	 * @var boolean
	 */
	protected $published = FALSE;


	/**
	 * Constructs this post
	 *
	 * @author Robert Lemke <robert@typo3.org>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function __construct() {
		$this->date = new \DateTime();
	}

	/**
	 * Sets the blog this post is part of
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog
	 * @return void
	 */
	public function setBlog(\F3\Blog\Domain\Model\Blog $blog) {
		$this->blog = $blog;
	}

	/**
	 * Returns the blog this post is part of
	 *
	 * @return \F3\Blog\Domain\Model\Blog The blog this post is part of
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getBlog() {
		return $this->blog;
	}

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
	 * Getter for title
	 *
	 * @return string
	 * @author Matthias Hoermann <hoermann@saltation.de>
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Setter for date
	 *
	 * @param \DateTime $date
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setDate(\DateTime $date) {
		$this->date = $date;
	}

	/**
	 * Getter for date
	 *
	 *
	 * @return \DateTime
	 * @author Matthias Hoermann <hoermann@saltation.de>
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Setter for tags
	 *
	 * @param array $tags One or more \F3\Blog\Domain\Model\Tag objects
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setTags(array $tags) {
		$this->tags = $tags;
	}

	/**
	 * Adds a tag to this post
	 *
	 * @param \F3\Blog\Domain\Model\Tag $tag
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function addTag(\F3\Blog\Domain\Model\Tag $tag) {
		$this->tags[] = $tag;
	}

	/**
	 * Getter for tags
	 *
	 * @return array holding \F3\Blog\Domain\Model\Tag objects
	 * @author Matthias Hoermann <hoermann@saltation.de>
	 */
	public function getTags() {
		return $this->tags;
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
	 * Getter for author
	 *
	 * @return string
	 * @author Matthias Hoermann <hoermann@saltation.de>
	 */
	public function getAuthor() {
		return $this->author;
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
	 * Getter for content
	 *
	 * @return string
	 * @author Matthias Hoermann <hoermann@saltation.de>
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Sets the votes for this post
	 *
	 * @param integer $votes
	 * @return void
	 * @author Matthias Hoermann <hoermann@saltation.de>
	 */
	public function setVotes($votes) {
		$this->votes = $votes;
	}

	/**
	 * Getter for votes
	 *
	 * @return integer
	 * @author Matthias Hoermann <hoermann@saltation.de>
	 */
	public function getVotes() {
		return $this->votes;
	}

	/**
	 * Setter for the comments to this post
	 *
	 * @param array $comments an array of \F3\Blog\Domain\Model\Comment instances
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setComments(array $comments) {
		$this->comments = $comments;
	}

	/**
	 * Adds a comment to this post
	 *
	 * @param \F3\Blog\Domain\Model\Comment $comment
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function addComment(\F3\Blog\Domain\Model\Comment $comment) {
		$this->comments[] = $comment;
	}

	/**
	 * Returns the comments to this post
	 *
	 * @return array of \F3\Blog\Domain\Model\Comment
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getComments() {
		return $this->comments;
	}

	/**
	 * Sets the published/unpublished state for this post
	 *
	 * @param boolean $published
	 * @return void
	 * @author Matthias Hoermann <hoermann@saltation.de>
	 */
	public function setPublished($published) {
		$this->published = $published;
	}

	/**
	 * Getter for published/unpublished state of this post
	 *
	 * @return boolean
	 * @author Matthias Hoermann <hoermann@saltation.de>
	 */
	public function getPublished() {
		return $this->published;
	}

	/**
	 * Returns this post as a formatted string
	 *
	 * @return string
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function __toString() {
		return $this->title . chr(10) .
			' written on ' . $this->date->format('Y-m-d') . chr(10) .
			' by ' . $this->author . chr(10) .
			wordwrap($this->content, 70, chr(10)) . chr(10) .
			implode(', ', $this->tags);
	}
}
?>