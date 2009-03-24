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
 * A blog
 *
 * @package Blog
 * @subpackage Domain
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Blog {

	/**
	 * The blog's name. Also acts as the identifier.
	 *
	 * @var string
	 * @validate Alphanumeric, Length(minimum = 3, maximum = 50)
	 * @identity
	 */
	protected $name = '';

	/**
	 * A short description of the blog
	 *
	 * @var string
	 * @validate Text, Length(maximum = 150)
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
		# FIXME getPosts() must return a clone of $this->posts, but currently PHP bug #47671 blocks that
		return $this->posts;
	}

}
?>