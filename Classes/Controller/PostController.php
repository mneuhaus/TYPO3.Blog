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
 * The posts controller for the Blog package
 *
 * @package Blog
 * @subpackage Controller
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PostController extends \F3\FLOW3\MVC\Controller\ActionController {

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
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog which will contain the new post
	 * @param F3\Blog\Domain\Model\Post $newPost A fresh post object taken as a basis for the rendering
	 * @return string An HTML form for creating a new post
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function newAction(\F3\Blog\Domain\Model\Blog $blog, \F3\Blog\Domain\Model\Post $newPost = NULL) {
		$this->view->assign('blog', $blog);
		$this->view->assign('newPost', $newPost);
	}

	/**
	 * Creates a new post
	 *
	 * @param F3\Blog\Domain\Model\Blog $blog The blog which will contain the new post
	 * @param F3\Blog\Domain\Model\Post $newPost A fresh Post object which has not yet been added to the repository
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function createAction(\F3\Blog\Domain\Model\Blog $blog, \F3\Blog\Domain\Model\Post $newPost) {
		$blog->addPost($newPost);
		$this->postRepository->add($newPost);
		$this->pushFlashMessage('Your new post was created.');
		$this->redirect('index', NULL, NULL, array('blog' => $blog));
	}

	/**
	 * Error handling. This action is called if an action could not be called
	 * due to validation errors of their arguments.
	 *
	 * @return void
	 * @author Robert Lemke
	 */
	public function errorAction() {
		$this->pushFlashMessage(implode('<br />', $this->argumentsMappingResults->getErrors()));
		switch ($this->actionMethodName) {
			case 'createAction' :
				$this->forward('new', NULL, NULL, $this->request->getArguments());
			break;
		}
		return parent::errorAction();
	}
}

?>