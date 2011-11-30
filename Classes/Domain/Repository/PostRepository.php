<?php
namespace TYPO3\Blog\Domain\Repository;

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

use \TYPO3\FLOW3\Persistence\QueryInterface;

/**
 * A repository for Blog Posts
 *
 */
class PostRepository extends \TYPO3\FLOW3\Persistence\Repository {

	/**
	 * Finds posts by the specified blog
	 *
	 * @param \TYPO3\Blog\Domain\Model\Blog $blog The blog the post must refer to
	 * @param integer $limit The number of posts to return at max
	 * @return \TYPO3\FLOW3\Persistence\QueryResultProxy The posts
	 */
	public function findByBlog(\TYPO3\Blog\Domain\Model\Blog $blog) {
		$query = $this->createQuery();
		return $query->matching($query->equals('blog', $blog))
			->setOrderings(array('date' => QueryInterface::ORDER_DESCENDING))
			->execute();
	}

	/**
	 * Finds posts by the specified tag and blog
	 *
	 * @param \TYPO3\Blog\Domain\Model\Tag $tag
	 * @param \TYPO3\Blog\Domain\Model\Blog $blog The blog the post must refer to
	 * @return \TYPO3\FLOW3\Persistence\QueryResultProxy The posts
	 */
	public function findByTagAndBlog(\TYPO3\Blog\Domain\Model\Tag $tag, \TYPO3\Blog\Domain\Model\Blog $blog) {
		$query = $this->createQuery();
		return $query->matching(
				$query->logicalAnd(
					$query->equals('blog', $blog),
					$query->contains('tags', $tag)
				)
			)
			->setOrderings(array('date' => QueryInterface::ORDER_DESCENDING))
			->execute();
	}

	/**
	 * Finds posts by the specified category and blog
	 *
	 * @param \TYPO3\Blog\Domain\Model\Category $category
	 * @param \TYPO3\Blog\Domain\Model\Blog $blog The blog the post must refer to
	 * @return \TYPO3\FLOW3\Persistence\QueryResultProxy The posts
	 */
	public function findByCategoryAndBlog(\TYPO3\Blog\Domain\Model\Category $category, \TYPO3\Blog\Domain\Model\Blog $blog) {
		$query = $this->createQuery();
		return $query->matching(
				$query->logicalAnd(
					$query->equals('blog', $blog),
					$query->equals('category', $category)
				)
			)
			->setOrderings(array('date' => QueryInterface::ORDER_DESCENDING))
			->execute();
	}

	/**
	 * Finds the previous of the given post
	 *
	 * @param \TYPO3\Blog\Domain\Model\Post $post The reference post
	 * @return \TYPO3\Blog\Domain\Model\Post
	 */
	public function findPrevious(\TYPO3\Blog\Domain\Model\Post $post) {
		$query = $this->createQuery();
		return $query->matching($query->lessThan('date', $post->getDate()))
			->setOrderings(array('date' => \TYPO3\FLOW3\Persistence\QueryInterface::ORDER_DESCENDING))
			->execute()
			->getFirst();
	}

	/**
	 * Finds the post next to the given post
	 *
	 * @param \TYPO3\Blog\Domain\Model\Post $post The reference post
	 * @return \TYPO3\Blog\Domain\Model\Post
	 */
	public function findNext(\TYPO3\Blog\Domain\Model\Post $post) {
		$query = $this->createQuery();
		return $query->matching($query->greaterThan('date', $post->getDate()))
			->setOrderings(array('date' => \TYPO3\FLOW3\Persistence\QueryInterface::ORDER_ASCENDING))
			->execute()
			->getFirst();
	}

	/**
	 * Finds most recent posts by the specified blog
	 *
	 * @param \TYPO3\Blog\Domain\Model\Blog $blog The blog the post must refer to
	 * @param integer $limit The number of posts to return at max
	 * @return \TYPO3\FLOW3\Persistence\QueryResultProxy The posts
	 */
	public function findRecentByBlog(\TYPO3\Blog\Domain\Model\Blog $blog, $limit = 5) {
		$query = $this->createQuery();
		return $query->matching($query->equals('blog', $blog))
			->setOrderings(array('date' => QueryInterface::ORDER_DESCENDING))
			->setLimit($limit)
			->execute();
	}

	/**
	 * Finds most recent posts excluding the given post
	 *
	 * @param \TYPO3\Blog\Domain\Model\Post $post Post to exclude from result
	 * @param integer $limit The number of posts to return at max
	 * @return array All posts of the $post's blog except for $post
	 */
	public function findRecentExceptThis(\TYPO3\Blog\Domain\Model\Post $post, $limit = 20) {
		$query = $this->createQuery();
		$posts = $query->matching($query->equals('blog', $post->getBlog()))
				->setOrderings(array('date' => \TYPO3\FLOW3\Persistence\QueryInterface::ORDER_DESCENDING))
				->setLimit($limit)
				->execute()
				->toArray();
		unset($posts[array_search($post, $posts)]);
		return $posts;


			// this is an alternative way of doing this when extending the Doctrine 2
			// specific repository and using DQL.
		return $this->entityManager
			->createQuery('SELECT p FROM \TYPO3\Blog\Domain\Model\Post p WHERE p.blog = :blog AND NOT p = :excludedPost ORDER BY p.date DESC')
			->setMaxResults($limit)
			->execute(array('blog' => $post->getBlog(), 'excludedPost' => $post));
	}

}
?>