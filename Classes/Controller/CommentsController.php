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
 * Comments controller for the Blog package
 *
 * @package Blog
 * @subpackage Controller
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class CommentsController extends \F3\FLOW3\MVC\Controller\ActionController {

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
	 *
	 * @param \F3\Blog\Domain\BlogRepository $blogRepository
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function injectBlogRepository(\F3\Blog\Domain\BlogRepository $blogRepository) {
		$this->blogRepository = $blogRepository;
	}

	/**
	 * Injects the URI Helper
	 *
	 * @param F3\FLOW3\MVC\View\Helper\URIHelper $URIHelper The URI Helper
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 * @todo this should not be a _view_ helper obviously
	 * @todo a global URIHelper has to be implemented which allows redirects too
	 *
	 */
	public function injectURIHelper(\F3\FLOW3\MVC\View\Helper\URIHelper $URIHelper) {
		$this->URIHelper = $URIHelper;
	}

	/**
	 * Initializes arguments for this controller
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function initializeArguments() {
		$this->arguments->addNewArgument('comment', 'F3\Blog\Domain\Comment');
		$this->arguments->addNewArgument('postUUID', 'UUID');
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

		$this->URIHelper->setRequest($this->request);
	}

	/**
	 * Action that adds a comment to a blog post and redirects to single view
	 *
	 * @return string The rendered view
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function createAction() {
		$postUUID = $this->arguments['postUUID']->getValue();
		$post = $this->blog->findPostByIdentifier($postUUID);

		$comment = $this->arguments['comment']->getValue();
		if ($comment != NULL) {
			$post->addComment($comment);
		}
		$this->redirect($this->request->getBaseURI() . $this->URIHelper->URIFor('show', array('postUUID' => $postUUID), 'Posts'));
	}
}

?>
