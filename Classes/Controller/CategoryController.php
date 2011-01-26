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
 * The category controller for the Blog package
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CategoryController extends \F3\Blog\Controller\AbstractBaseController {

	/**
	 * @inject
	 * @var F3\Blog\Domain\Repository\CategoryRepository
	 */
	protected $categoryRepository;

	/**
	 * List action for this controller.
	 *
	 * @return string
	 */
	public function indexAction() {
		$this->view->assign('categories', $this->categoryRepository->findAll());
	}

	/**
	 * Creates a new category
	 *
	 * @param \F3\Blog\Domain\Model\Category $newCategory A fresh category object which has not yet been added to the repository
	 * @return void
	 */
	public function createAction(\F3\Blog\Domain\Model\Category $newCategory) {
		$this->categoryRepository->add($newCategory);
		$this->flashMessageContainer->add('Your new category was created.');
		$this->redirect('index');
	}

	/**
	 * Displays a form for editing an existing category
	 *
	 * @param \F3\Blog\Domain\Model\Category $category An existing category object taken as a basis for the rendering
	 * @dontvalidate $category
	 * @return string An HTML form for editing a category
	 */
	public function editAction(\F3\Blog\Domain\Model\Category $category) {
		$this->view->assign('category', $category);
	}

	/**
	 * Updates an existing category
	 *
	 * @param \F3\Blog\Domain\Model\Category $category A not yet persisted clone of the original category containing the modifications
	 * @return void
	 */
	public function updateAction(\F3\Blog\Domain\Model\Category $category) {
		$this->categoryRepository->update($category);
		$this->flashMessageContainer->add('Your category has been updated.');
		$this->redirect('index');
	}

	/**
	 * Deletes an existing category
	 *
	 * @param \F3\Blog\Domain\Model\Category $category The category to remove
	 * @return void
	 */
	public function deleteAction(\F3\Blog\Domain\Model\Category $category) {
		$this->categoryRepository->remove($category);
		$this->flashMessageContainer->add('The category has been deleted.');
		$this->redirect('index');
	}

	/**
	 * Override getErrorFlashMessage to present nice flash error messages.
	 *
	 * @return string
	 */
	protected function getErrorFlashMessage() {
		switch ($this->actionMethodName) {
			case 'createAction' :
				return 'Could not create the new category:';
			default :
				return parent::getErrorFlashMessage();
		}
	}
}
?>