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
 * @package Blog
 * @subpackage Controller
 * @version $Id$
 */

/**
 * The Blog controller for the Blog package
 *
 * @package Blog
 * @subpackage Controller
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
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function indexAction() {
		$this->view->assign('blogs', $this->blogRepository->findAll());
	}

	/**
	 * Shows a single blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog to show
	 * @return string The rendered view of a single blog
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function showAction(\F3\Blog\Domain\Model\Blog $blog) {
		$this->view->assign('blog', $blog);
	}

	/**
	 * Displays a form for creating a new blog
	 *
	 * @param F3\Blog\Domain\Model\Blog $newBlog A fresh blog object taken as a basis for the rendering
	 * @return string An HTML form for creating a new blog
	 * @author Robert Lemke <robert@typo3.org>
	 * @validate $newBlog Raw
	 */
	public function newAction(\F3\Blog\Domain\Model\Blog $newBlog = NULL) {
		$this->view->assign('newBlog', $newBlog);
	}

	/**
	 * Creates a new blog
	 *
	 * @param F3\Blog\Domain\Model\Blog $newBlog A fresh Blog object which has not yet been added to the repository
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function createAction(\F3\Blog\Domain\Model\Blog $newBlog) {
		$this->blogRepository->add($newBlog);
		$this->pushFlashMessage('Your new blog was created.');
		$this->redirect('index');
	}

	/**
	 * Edits an existing blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog to edit or the blog with updated properties
	 * @param \F3\Blog\Domain\Model\Blog $existingBlog The existing unmodified blog or NULL to use the blog
	 * @return string Form for editing the existing blog
	 * @author Robert Lemke <robert@typo3.org>
	 * @validate $blog Raw
	 */
	public function editAction(\F3\Blog\Domain\Model\Blog $blog, \F3\Blog\Domain\Model\Blog $existingBlog = NULL) {
		if ($existingBlog === NULL) {
			$existingBlog = $blog;
		}
		$this->view->assign('blog', $blog);
		$this->view->assign('existingBlog', $existingBlog);
	}

	/**
	 * Updates an existing blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The modified blog
	 * @param \F3\Blog\Domain\Model\Blog $existingBlog The existing unmodified blog
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function updateAction(\F3\Blog\Domain\Model\Blog $blog, \F3\Blog\Domain\Model\Blog $existingBlog) {
		$this->blogRepository->replace($existingBlog, $blog);
		$this->pushFlashMessage('Your blog has been updated.');
		$this->redirect('index');
	}

	/**
	 * Deletes an existing blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog to delete
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
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
	 * @return void
	 * @author Christopher Hlubek <hlubek@networkteam.com>
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