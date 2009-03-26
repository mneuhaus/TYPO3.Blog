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
 * A repository for Blog Posts
 *
 * @package Blog
 * @subpackage Domain
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class PostRepository extends \F3\FLOW3\Persistence\Repository {

	/**
	 * @inject
	 * @var \F3\FLOW3\Persistence\ManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * Finds posts by the specified blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog the post must refer to
	 * @return array The posts
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function findByBlog(\F3\Blog\Domain\Model\Blog $blog) {
		$blogUUID = $this->persistenceManager->getBackend()->getUUIDByObject($blog);
		$query = $this->createQuery();
		return $query->matching($query->equals('blog', $blogUUID))->execute();
	}
}
?>