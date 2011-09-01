<?php
namespace TYPO3\Blog\Controller;

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
 * Comments controller for the Blog package
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CommentController extends \TYPO3\Blog\Controller\AbstractBaseController {

	/**
	 * Creates a new comment
	 *
	 * @param \TYPO3\Blog\Domain\Model\Post $post The post which will contain the new comment
	 * @param \TYPO3\Blog\Domain\Model\Comment $newComment A fresh Comment object which has not yet been added to the repository
	 * @return void
	 */
	public function createAction(\TYPO3\Blog\Domain\Model\Post $post, \TYPO3\Blog\Domain\Model\Comment $newComment) {
		$post->addComment($newComment);
		$this->postRepository->update($post);
		$this->flashMessageContainer->add('Your new comment was created.');
		$this->emitCommentCreated($newComment, $post);
		$this->redirect('show', 'Post', NULL, array('post' => $post));
	}

	/**
	 * Removes a comment
	 *
	 * @param \TYPO3\Blog\Domain\Model\Post $post
	 * @param \TYPO3\Blog\Domain\Model\Comment $comment
	 * @return void
	 */
	public function deleteAction(\TYPO3\Blog\Domain\Model\Post $post, \TYPO3\Blog\Domain\Model\Comment $comment) {
		$post->removeComment($comment);
		$this->postRepository->update($post);
		$this->redirect('show', 'Post', NULL, array('post' => $post));
	}

	/**
	 * Override getErrorFlashMessage to present nice flash error messages.
	 *
	 * @return string
	 */
	protected function getErrorFlashMessage() {
		switch ($this->actionMethodName) {
			case 'createAction' :
				return 'Could not create the new comment.';
			default :
				return parent::getErrorFlashMessage();
		}
	}

	/**
	 * @param \TYPO3\Blog\Domain\Model\Comment $comment
	 * @param \TYPO3\Blog\Domain\Model\Post $post
	 * @return void
	 * @signal
	 */
	protected function emitCommentCreated(\TYPO3\Blog\Domain\Model\Comment $comment, \TYPO3\Blog\Domain\Model\Post $post) {}
}

?>