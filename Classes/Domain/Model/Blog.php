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
 * @package Blog
 * @subpackage Domain
 * @version $Id$
 */

/**
 * A blog
 *
 * @package Blog
 * @subpackage Domain
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @scope prototype
 * @entity
 */
class Blog {

	/**
	 * The blog's name. Also acts as the identifier.
	 *
	 * @var string
	 * @validate Alphanumeric, StringLength(minimum = 3, maximum = 50)
	 * @identity
	 */
	protected $name = '';

	/**
	 * A short description of the blog
	 *
	 * @var string
	 * @validate Text, StringLength(maximum = 150)
	 */
	protected $description = '';

	/**
	 * The blog's logo
	 *
	 * @var string
	 */
	protected $logo;

	/**
	 * The posts contained in this blog
	 *
	 * @var \SplObjectStorage
	 * @lazy
	 */
	protected $posts;

	/**
	 * Constructs a new Blog
	 *
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function __construct() {
		$this->posts = new \SplObjectStorage();
	}

	/**
	 * Sets this blog's name
	 *
	 * @param string $name The blog's name
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the blog's name
	 *
	 * @return string The blog's name
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the description for the blog
	 *
	 * @param string $description
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the description
	 *
	 * @return string
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Adds a post to this blog
	 *
	 * @param \F3\Blog\Domain\Model\Post $post
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function addPost(\F3\Blog\Domain\Model\Post $post) {
		$post->setBlog($this);
		$this->posts->attach($post);
	}

	/**
	 * Returns all posts in this blog
	 *
	 * @return \SplObjectStorage
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getPosts() {
		if ($this->posts instanceof \F3\FLOW3\Persistence\LazyLoadingProxy) {
			$this->posts->_loadRealInstance();
		}
		return clone $this->posts;
	}

}
?>