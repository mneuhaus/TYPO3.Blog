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
 * A repository for Blogs
 *
 * @package Blog
 * @subpackage Domain
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class BlogRepository extends \F3\FLOW3\Persistence\Repository {

	/**
	 * @inject
	 * @var \F3\Blog\Domain\Model\PostRepository
	 */
	protected $postRepository;

	/**
	 * Returns one or more Blogs with a matching name if found.
	 *
	 * @param string $name The name to match against
	 * @return array
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function findByName($name) {
		$query = $this->createQuery();
		$blogs = $query->matching($query->equals('name', $name))->execute();

		return $blogs;
	}

	/**
	 * Remove the blog's posts before removing the blog itself.
	 *
	 * @param \F3\Blog\Domain\Model\Blog
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function remove($blog) {
		foreach ($blog->getPosts() as $post) {
			$this->postRepository->remove($post);
		}
		parent::remove($blog);
	}
}
?>