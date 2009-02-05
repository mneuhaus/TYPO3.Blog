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
 * The posts controller for the Blog package
 *
 * @package Blog
 * @subpackage Controller
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class PostController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * Use Fluid as the default template engine
	 * @var string
	 */
	protected $viewObjectName = 'F3\Fluid\View\TemplateView';

	/**
	 * @inject
	 * @var \F3\Blog\Domain\BlogRepository
	 */
	protected $blogRepository;

	/**
	 * @inject
	 * @var \F3\Blog\Domain\PostRepository
	 */
	protected $postRepository;

	/**
	 * @var \F3\Blog\Domain\Blog
	 */
	protected $blog;

	/**
	 * Initializes the current action
	 *
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function initializeAction() {
		$blogs = $this->blogRepository->findByName('FLOW3');
		if (count($blogs) && $blogs[0] instanceof \F3\Blog\Domain\Blog) {
			$this->blog = $blogs[0];
		} else {
			$this->throwStatus(404, NULL, 'No blogs found, run the setup controller to create one.');
		}
	}

	/**
	 * Index action for this controller. Displays latest posts
	 *
	 * @return string The rendered view
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function indexAction() {
		$this->view->assign('posts', $this->blog->getLatestPosts($this->settings['latestView']['maxItems']));
		return $this->view->render();
	}

	/**
	 * Displays a list of posts matching a given Tag
	 *
	 * @param string $tag
	 * @return string The rendered view
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function postsByTagAction($tag) {
		$this->view->assign('tag', $tag);
		$this->view->assign('posts', $this->blog->findPostsByTag($tag));
		return $this->view->render();
	}

	/**
	 * Action that displays one single post
	 *
	 * @param string $postUUID
	 * @return string The rendered view
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function showAction($postUUID) {
		$this->view->assign('post', $this->postRepository->findByUUID($postUUID));
		return $this->view->render();
	}

}

?>