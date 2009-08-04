<?php
declare(ENCODING = 'utf-8');
namespace F3\Blog\Controller;

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
 * The Blog controller for the Blog package
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BlogController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * @var \F3\Blog\Domain\Repository\BlogRepository
	 * @inject
	 */
	protected $blogRepository;

	/**
	 * Index action for this controller. Displays a list of blogs.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$this->view->assign('blogs', $this->blogRepository->findAll());
	}

	/**
	 * Displays a form for creating a new blog
	 *
	 * @param F3\Blog\Domain\Model\Blog $newBlog A fresh blog object taken as a basis for the rendering
	 * @return string An HTML form for creating a new blog
	 */
	public function newAction(\F3\Blog\Domain\Model\Blog $newBlog = NULL) {
		$this->view->assign('newBlog', $newBlog);
	}

	/**
	 * Creates a new blog
	 *
	 * @param F3\Blog\Domain\Model\Blog $newBlog A fresh Blog object which has not yet been added to the repository
	 * @return void
	 */
	public function createAction(\F3\Blog\Domain\Model\Blog $newBlog) {
		$this->blogRepository->add($newBlog);
		$this->pushFlashMessage('Your new blog was created.');
		$this->redirect('index');
	}

	/**
	 * Edits an existing blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $existingBlog The existing unmodified blog
	 * @param \F3\Blog\Domain\Model\Blog $updatedBlog The modified, updated blog or NULL if the existing blog should be cloned
	 * @return string Form for editing the existing blog
	 * @validate $updatedBlog Raw
	 */
	public function editAction(\F3\Blog\Domain\Model\Blog $existingBlog, \F3\Blog\Domain\Model\Blog $updatedBlog = NULL) {
		if ($updatedBlog === NULL) {
			$updatedBlog = $existingBlog;
		}

		$this->view->assign('existingBlog', $existingBlog);
		$this->view->assign('updatedBlog', $updatedBlog);
	}

	/**
	 * Updates an existing blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $existingBlog The existing unmodified blog
	 * @param \F3\Blog\Domain\Model\Blog $updatedBlog The updated blog
	 * @return void
	 */
	public function updateAction(\F3\Blog\Domain\Model\Blog $existingBlog, \F3\Blog\Domain\Model\Blog $updatedBlog) {
		$this->blogRepository->replace($existingBlog, $updatedBlog);
		$this->pushFlashMessage('Your blog has been updated.');
		$this->redirect('index');
	}

	/**
	 * Deletes an existing blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog to delete
	 * @return void
	 */
	public function deleteAction(\F3\Blog\Domain\Model\Blog $blog) {
		$this->blogRepository->remove($blog);
		$this->pushFlashMessage('Your blog has been removed.');
		$this->redirect('index');
	}

	/**
	 * Override getErrorFlashMessage to present
	 * nice flash error messages.
	 *
	 * @return string
	 */
	protected function getErrorFlashMessage() {
		switch ($this->actionMethodName) {
			case 'updateAction' :
				return 'Could not update the blog:';
			case 'createAction' :
				return 'Could not create the new blog:';
			default :
				return parent::getErrorFlashMessage();
		}
	}
}
?>