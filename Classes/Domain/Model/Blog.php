<?php
declare(ENCODING = 'utf-8');
namespace F3\Blog\Domain\Model;

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
 * A blog
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @scope prototype
 * @entity
 */
class Blog {

	/**
	 * The blog's title.
	 *
	 * @var string
	 * @validate Text, StringLength(minimum = 1, maximum = 80)
	 */
	protected $title = '';

	/**
	 * A short description of the blog
	 *
	 * @var string
	 * @validate Text, StringLength(maximum = 150)
	 */
	protected $description = '';

	/**
	 * The posts contained in this blog
	 *
	 * @var \SplObjectStorage<\F3\Blog\Domain\Model\Post>
	 * @lazy
	 */
	protected $posts;

	/**
	 * Constructs a new Blog
	 *
	 */
	public function __construct() {
		$this->posts = new \SplObjectStorage();
	}

	/**
	 * Sets this blog's title
	 *
	 * @param string $title The blog's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the blog's title
	 *
	 * @return string The blog's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the description for the blog
	 *
	 * @param string $description The blog description or "tag line"
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the description
	 *
	 * @return string The blog description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Adds a post to this blog
	 *
	 * @param \F3\Blog\Domain\Model\Post $post
	 * @return void
	 */
	public function addPost(\F3\Blog\Domain\Model\Post $post) {
		$post->setBlog($this);
		$this->posts->attach($post);
	}

	/**
	 * Removes a post from this blog
	 *
	 * @param \F3\Blog\Domain\Model\Post $post
	 * @return void
	 */
	public function removePost(\F3\Blog\Domain\Model\Post $post) {
		$this->posts->detach($post);
	}

	/**
	 * Returns all posts in this blog
	 *
	 * @return \SplObjectStorage<\F3\Blog\Domain\Model\Post> The posts of this blog
	 */
	public function getPosts() {
		if ($this->posts instanceof \F3\FLOW3\Persistence\LazyLoadingProxy) {
			$this->posts->_loadRealInstance();
		}
		return clone $this->posts;
	}

}
?>