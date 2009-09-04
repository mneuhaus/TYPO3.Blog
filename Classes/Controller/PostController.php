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
 * The posts controller for the Blog package
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PostController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * @inject
	 * @var \F3\Blog\Domain\Repository\BlogRepository
	 */
	protected $blogRepository;

	/**
	 * @inject
	 * @var \F3\Blog\Domain\Repository\PostRepository
	 */
	protected $postRepository;

	/**
	 * List action for this controller. Displays latest posts
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog to show the posts of
	 * @return string
	 */
	public function indexAction(\F3\Blog\Domain\Model\Blog $blog) {
		$posts = $this->postRepository->findByBlog($blog);
		$this->view->assign('blog', $blog);
		$this->view->assign('posts', $posts);
		$this->view->assign('recentPosts', $this->postRepository->findRecentByBlog($blog));
	}

	/**
	 * Action that displays one single post
	 *
	 * @param \F3\Blog\Domain\Model\Post $post The post to display
	 * @return void
	 */
	public function showAction(\F3\Blog\Domain\Model\Post $post) {
		$this->view->assign('post', $post);
		$this->view->assign('blog', $post->getBlog());
		$this->view->assign('previousPost', $this->postRepository->findPrevious($post));
		$this->view->assign('nextPost', $this->postRepository->findNext($post));
		$this->view->assign('recentPosts', $this->postRepository->findRecentByBlog($post->getBlog()));
	}

	/**
	 * Displays a form for creating a new post
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog which will contain the new post
	 * @param \F3\Blog\Domain\Model\Post $newPost A fresh post object taken as a basis for the rendering
	 * @return string An HTML form for creating a new post
	 * @dontvalidate $newPost
	 */
	public function newAction(\F3\Blog\Domain\Model\Blog $blog, \F3\Blog\Domain\Model\Post $newPost = NULL) {
		$this->view->assign('blog', $blog);
		$this->view->assign('existingPosts', $this->postRepository->findByBlog($blog));
		$this->view->assign('newPost', $newPost);
	}

	/**
	 * Creates a new post
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog which will contain the new post
	 * @param \F3\Blog\Domain\Model\Post $newPost A fresh Post object which has not yet been added to the repository
	 * @return void
	 */
	public function createAction(\F3\Blog\Domain\Model\Blog $blog, \F3\Blog\Domain\Model\Post $newPost) {
		$blog->addPost($newPost);
		$this->pushFlashMessage('Your new post was created.');
		$this->redirect('index', NULL, NULL, array('blog' => $blog));
	}

	/**
	 * Override getErrorFlashMessage to present nice flash error messages.
	 *
	 * @return string
	 */
	protected function getErrorFlashMessage() {
		switch ($this->actionMethodName) {
			case 'createAction' :
				return 'Could not create the new post:';
			default :
				return parent::getErrorFlashMessage();
		}
	}
}
?>