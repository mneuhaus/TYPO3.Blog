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
	protected $defaultViewObjectName = 'F3\Fluid\View\TemplateView';

	/**
	 * @inject
	 * @var \F3\Blog\Domain\Model\BlogRepository
	 */
	protected $blogRepository;

	/**
	 * @inject
	 * @var \F3\Blog\Domain\Model\PostRepository
	 */
	protected $postRepository;

	/**
	 * @var \F3\Blog\Domain\Model\Blog
	 */
	protected $blog;

	/**
	 * List action for this controller. Displays latest posts
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog to show the posts of
	 * @return string
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function indexAction(\F3\Blog\Domain\Model\Blog $blog) {
		$posts = $this->postRepository->findByBlog($blog);
		$this->view->assign('blog', $blog);
		$this->view->assign('posts', $posts);
	}

	/**
	 * Action that displays one single post
	 *
	 * @param \F3\Blog\Domain\Model\Post $post The post to display
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function showAction(\F3\Blog\Domain\Model\Post $post) {
		$this->view->assign('post', $post);
	}

	/**
	 * Displays a form for creating a new post
	 *
	 * @param F3\Blog\Domain\Model\Post $newPost A fresh post object taken as a basis for the rendering
	 * @return string An HTML form for creating a new post
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function newAction(\F3\Blog\Domain\Model\Post $newPost = NULL) {
		$this->view->assign('newPost', $newPost);
	}

}

?>