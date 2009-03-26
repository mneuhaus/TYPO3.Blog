<?php
declare(ENCODING = 'utf-8');
namespace F3\Blog\Controller;

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
 * @subpackage Controller
 * @version $Id$
 */

/**
 * The blogs controller for the Blog package
 *
 * @package Blog
 * @subpackage Controller
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class BlogController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * Use Fluid as the default template engine
	 * @var string
	 */
	protected $defaultViewObjectName = 'F3\Fluid\View\TemplateView';

	/**
	 * @inject
	 * @var \F3\Blog\Domain\Model\BlogRepository
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
	 * (No code needed, it's all automatic - really!)
	 *
	 * @return string An HTML form for creating a new blog
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function newAction() {
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
		$this->redirect('/blogs/');
	}


	/**
	 * Edits an existing blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog to show
	 * @return string Form for editing the existing blog
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function editAction(\F3\Blog\Domain\Model\Blog $blog) {
		$this->view->assign('blog', $blog);
	}

	/**
	 * Updates an existing blog
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The existing, unmodified blog
	 * @param \F3\Blog\Domain\Model\Blog $updatedBlog A clone of the original blog with the updated values already applied
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function updateAction(\F3\Blog\Domain\Model\Blog $blog, \F3\Blog\Domain\Model\Blog $updatedBlog) {
		$this->blogRepository->replace($blog, $updatedBlog);
		$this->redirect('/blogs/');
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
		$this->redirect('/blogs/');
	}
}
?>