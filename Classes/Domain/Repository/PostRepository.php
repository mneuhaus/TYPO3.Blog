<?php
declare(ENCODING = 'utf-8');
namespace F3\Blog\Domain\Repository;

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
 * A repository for Blog Posts
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PostRepository extends \F3\FLOW3\Persistence\Repository {

	/**
	 * Finds posts by the specified blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog the post must refer to
	 * @param integer $limit The number of posts to return at max
	 * @return \F3\FLOW3\Persistence\QueryResultProxy The posts
	 */
	public function findByBlog(\F3\Blog\Domain\Model\Blog $blog, $limit = 20) {
		$query = $this->createQuery();
		return $query->matching($query->equals('blog', $blog))
			->setOrderings(array('date' => \F3\FLOW3\Persistence\QueryInterface::ORDER_DESCENDING))
			->setLimit($limit)
			->execute();
	}

	/**
	 * Finds posts by the specified tag and blog
	 *
	 * @param \F3\Blog\Domain\Model\Tag $tag
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog the post must refer to
	 * @param integer $limit The number of posts to return at max
	 * @return \F3\FLOW3\Persistence\QueryResultProxy The posts
	 */
	public function findByTagAndBlog(\F3\Blog\Domain\Model\Tag $tag, \F3\Blog\Domain\Model\Blog $blog, $limit = 20) {
		$query = $this->createQuery();
		return $query->matching(
				$query->logicalAnd(
					$query->equals('blog', $blog),
					$query->contains('tags', $tag)
				)
			)
			->setOrderings(array('date' => \F3\FLOW3\Persistence\QueryInterface::ORDER_DESCENDING))
			->setLimit($limit)
			->execute();
	}

	/**
	 * Finds the previous of the given post
	 *
	 * @param \F3\Blog\Domain\Model\Post $post The reference post
	 * @return \F3\Blog\Domain\Model\Post
	 */
	public function findPrevious(\F3\Blog\Domain\Model\Post $post) {
		$query = $this->createQuery();
		return $query->matching($query->lessThan('date', $post->getDate()))
			->setOrderings(array('date' => \F3\FLOW3\Persistence\QueryInterface::ORDER_DESCENDING))
			->execute()
			->getFirst();
	}

	/**
	 * Finds the post next to the given post
	 *
	 * @param \F3\Blog\Domain\Model\Post $post The reference post
	 * @return \F3\Blog\Domain\Model\Post
	 */
	public function findNext(\F3\Blog\Domain\Model\Post $post) {
		$query = $this->createQuery();
		return $query->matching($query->greaterThan('date', $post->getDate()))
			->setOrderings(array('date' => \F3\FLOW3\Persistence\QueryInterface::ORDER_ASCENDING))
			->execute()
			->getFirst();
	}

	/**
	 * Finds most recent posts by the specified blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog the post must refer to
	 * @param integer $limit The number of posts to return at max
	 * @return \F3\FLOW3\Persistence\QueryResultProxy The posts
	 */
	public function findRecentByBlog(\F3\Blog\Domain\Model\Blog $blog, $limit = 5) {
		$query = $this->createQuery();
		return $query->matching($query->equals('blog', $blog))
			->setOrderings(array('date' => \F3\FLOW3\Persistence\QueryInterface::ORDER_DESCENDING))
			->setLimit($limit)
			->execute();
	}

	/**
	 * Finds most recent posts by the specified blog excluding the given post
	 *
	 * @param \F3\Blog\Domain\Model\Post $postToExclude Post to exclude from result
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog the post must refer to
	 * @param integer $limit The number of posts to return at max
	 * @return array All posts of the given $blog except for $postToExclude
	 */
	public function findRemainingByBlog(\F3\Blog\Domain\Model\Post $postToExclude, \F3\Blog\Domain\Model\Blog $blog, $limit = 20) {
		$query = $this->createQuery();
		$posts = $query->matching(
				$query->logicalAnd(
					$query->equals('blog', $blog)
				)
			)
			->setOrderings(array('date' => \F3\FLOW3\Persistence\QueryInterface::ORDER_DESCENDING))
			->setLimit($limit)
			->execute()
			->toArray();
		unset($posts[array_search($postToExclude, $posts)]);
		return $posts;
	}

}
?>