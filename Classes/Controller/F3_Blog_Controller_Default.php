<?php
declare(ENCODING = 'utf-8');

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
 * The default controller for the Blog package
 *
 * @package Blog
 * @subpackage Controller
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class F3_Blog_Controller_Default extends F3_FLOW3_MVC_Controller_ActionController {

	/**
	 * @var F3_Blog_Domain_BlogRepository
	 */
	protected $blogRepository;

	/**
	 * @var F3_Blog_Domain_Blog
	 */
	protected $blog;

	/**
	 * Injects the BlogRepository
	 * @param F3_Blog_Domain_BlogRepository $blogRepository
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @required
	 */
	public function injectBlogRepository(F3_Blog_Domain_BlogRepository $blogRepository) {
		$this->blogRepository = $blogRepository;
	}

	/**
	 * Initializes the controller
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function initializeController() {
		$this->supportedRequestTypes = array('F3_FLOW3_MVC_Web_Request');

		$blog = $this->componentManager->getComponent('F3_Blog_Domain_Blog', 'FLOW3');
		$this->blogRepository->add($blog);
		$post = $this->componentManager->getComponent('F3_Blog_Domain_Post');
		$blog->addPost($post);

		$blog = $this->blogRepository->findByName('FLOW3');
		if ($blog instanceof F3_Blog_Domain_Blog) {
			$this->blog = $blog;
		} else {
			throw new RuntimeException('No Blog found in BlogRepository', 1212490598);
		}
	}

	/**
	 * Default action for this controller
	 *
	 * @return string The rendered view
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function defaultAction() {
		return $this->latestPostsAction();
	}

	/**
	 * Action that display the latest posts
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function latestPostsAction() {
		$latestPostsView = $this->componentManager->getComponent('F3_Blog_View_LatestPosts');
		$latestPostsView->setPosts($this->blog->getLatestPosts(5));
		return $latestPostsView->render();
	}
}

?>