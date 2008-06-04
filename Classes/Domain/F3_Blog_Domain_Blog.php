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
 * A blog
 *
 * @package Blog
 * @subpackage Domain
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @entity
 */
class F3_Blog_Domain_Blog {

	/**
	 * The Blog's name
	 * @var string
	 */
	protected $name;

	/**
	 * The posts contained in this blog
	 * @var array of F3_Blog_Domain_Post
	 */
	protected $posts = array();

	/**
	 * Constructs a Blog
	 *
	 * @param string $name The name for the blog
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function __construct($name) {
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
	 * Adds a post to this blog
	 *
	 * @param F3_Blog_Domain_Post $post
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function addPost(F3_Blog_Domain_Post $post) {
		$this->posts[] = $post;
	}

	/**
	 * Returns all posts in this blog
	 *
	 * @return array of F3_Blog_Domain_Post
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getPosts() {
		return $this->posts;
	}

	/**
	 * Returns the latest $count posts from the blog
	 *
	 * @param integer $count
	 * @return array of F3_Blog_Domain_Post
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getLatestPosts($count = 5) {
		return array_slice($this->posts, -5, 5, TRUE);
	}

	/**
	 * Returns this blog as a formatted string
	 *
	 * @return string
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function __toString() {
		return $this->name;
	}
}
?>