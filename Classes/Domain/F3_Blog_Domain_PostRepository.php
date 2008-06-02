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
class F3_Blog_Domain_PostRepository {


	/**
	 * @var array of F3_Blog_Domain_Post
	 */
	protected $posts = array();

	/**
	 * add
	 *
	 * -> triggers persistence in CR session
	 *
	 * @param unknown_type $post
	 */
	public function add($post) {
		$this->posts[] = $post;
	}

	/**
	 * remove
	 *
	 * -> triggers persistence in CR session
	 *
	 * @param unknown_type $post
	 */
	public function remove($post) {}

	public function findAll() {

	}

	public function findByTitle($title) {
		$query = $this->queryFactory->create()->
			select('F3_Blog_Domain_Post');

// How to write criteria in fluent interface?
	}

	public function findMostRecentPosts() {
		$this->persistenceManager->savePending('F3_Blo');

		$query = $this->persistenceManager->createQuery()->
			select('F3_Blog_Domain_Post')->
			orderedDescendingBy('date')->
			limit(5);
		$posts = $query->execute();
	}
}
?>