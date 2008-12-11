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
class PostsController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * @var \F3\Blog\Domain\BlogRepository
	 */
	protected $blogRepository;

	/**
	 * @var \F3\Blog\Domain\Blog
	 */
	protected $blog;

	/**
	 * Injects the BlogRepository
	 * @param \F3\Blog\Domain\BlogRepository $blogRepository
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function injectBlogRepository(\F3\Blog\Domain\BlogRepository $blogRepository) {
		$this->blogRepository = $blogRepository;
	}

	/**
	 * Initializes arguments for this controller
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function initializeArguments() {
		$this->arguments->addNewArgument('postUUID', 'UUID');
		$this->arguments->addNewArgument('tag');
	}


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
		$this->view->assign('baseURI', $this->request->getBaseURI());
		$this->view->assign('posts', $this->blog->getLatestPosts($this->settings['latestView']['maxItems']));
		return $this->view->render();
	}

	/**
	 * Displays a list of posts matching a given Tag
	 *
	 * @return string The rendered view
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function postsByTagAction() {
		$tag = $this->arguments['tag']->getValue();
		$this->view->assign('baseURI', $this->request->getBaseURI());
		$this->view->assign('tag', $tag);
		$this->view->assign('posts', $this->blog->findPostsByTag($tag));
		return $this->view->render();
	}

	/**
	 * Action that displays one single post
	 *
	 * @return string The rendered view
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function showAction() {
		$postUUID = $this->arguments['postUUID']->getValue();
		$post = $this->blog->findPostByIdentifier($postUUID);
		$this->view->assign('baseURI', $this->request->getBaseURI());
		$this->view->assign('post', $post);
		return $this->view->render();
	}
}

?>