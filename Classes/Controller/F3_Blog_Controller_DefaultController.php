<?php
declare(ENCODING = 'utf-8');
namespace F3::Blog::Controller;

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
class DefaultController extends F3::FLOW3::MVC::Controller::ActionController {

	/**
	 * @var F3::Blog::Domain::BlogRepository
	 */
	protected $blogRepository;

	/**
	 * @var F3::Blog::Domain::Blog
	 */
	protected $blog;

	/**
	 * Injects the BlogRepository
	 * @param F3::Blog::Domain::BlogRepository $blogRepository
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function injectBlogRepository(F3::Blog::Domain::BlogRepository $blogRepository) {
		$this->blogRepository = $blogRepository;
	}

	/**
	 * Initializes the controller
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function initializeController() {
		$this->supportedRequestTypes = array('F3::FLOW3::MVC::Web::Request');

		$blogs = $this->blogRepository->findByName('FLOW3');
		if (count($blogs) && $blogs[0] instanceof F3::Blog::Domain::Blog) {
			$this->blog = $blogs[0];
		} else {
			throw new RuntimeException('No Blog found in BlogRepository', 1212490598);
		}
	}

	/**
	 * Index action for this controller
	 *
	 * @return string The rendered view
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function indexAction() {
		return $this->latestPostsAction();
	}

	/**
	 * Action that display the latest posts
	 *
	 * @return string The rendered view
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function latestPostsAction() {
		$latestPostsView = $this->componentFactory->getComponent('F3::Blog::View::LatestPosts');
		$latestPostsView->setPosts($this->blog->getLatestPosts($this->settings->latestView->maxItems));
		return $latestPostsView->render();
	}
}

?>