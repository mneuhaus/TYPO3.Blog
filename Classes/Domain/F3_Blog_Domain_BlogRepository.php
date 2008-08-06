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
 * A repository for Blogs
 *
 * @package Blog
 * @subpackage Domain
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @repository of F3_Blog_Domain_Post
 */
class F3_Blog_Domain_BlogRepository extends F3_FLOW3_Persistence_Repository {

	/**
	 * Returns one or more Blogs with a matching name if found.
	 *
	 * @param string $name The name to match against
	 * @return array
	 */
	public function findByName($name) {
		$query = $this->queryFactory->create('F3_Blog_Domain_Blog');
		$blogs = $query->matching($query->equals('name', $name))->execute();
		foreach ($blogs as $blog) {
			$this->add($blog);
		}

		return $blogs;
	}
}
?>