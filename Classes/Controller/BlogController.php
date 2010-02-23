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
 * The blog controller for the Blog package
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BlogController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * @inject
	 * @var \F3\Blog\Domain\Repository\BlogRepository
	 */
	protected $blogRepository;

	/**
	 * @var blog
	 */
	protected $blog;

	/**
	 * Initializes any action.
	 *
	 * @return void
	 */
	public function initializeAction() {
		$this->blog = $this->blogRepository->findActive();
		if ($this->blog === FALSE) {
			$this->redirect('index', 'Setup');
		}
	}

	/**
	 * List action for this controller.
	 *
	 * @return string
	 */
	public function indexAction() {
		$this->forward('edit');
	}

	/**
	 * Displays a form for editing the properties of the blog
	 *
	 * @return string An HTML form for editing the blog properties
	 */
	public function editAction() {
		$this->view->assign('blog', $this->blog);
	}

	/**
	 * Updates the blog properties
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog  A not yet persisted clone of the original blog containing the modifications
	 * @return void
	 */
	public function updateAction(\F3\Blog\Domain\Model\Blog $blog) {
		$this->blogRepository->update($blog);
var_dump($blog->FLOW3_Persistence_isClone());
		$this->flashMessageContainer->add('Your blog details have been updated.');
		return 'x';
		$this->redirect('edit', 'Blog');
	}
}
?>