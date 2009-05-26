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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CommentController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * @inject
	 * @var \F3\FLOW3\MVC\View\Helper\URIHelper
	 * @todo this should not be a _view_ helper obviously
	 * @todo a global URIHelper has to be implemented which allows redirects too
	 */
	protected $URIHelper;

	/**
	 * Initializes additional arguments for this controller
	 *
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function initializeArguments() {
		$this->arguments->addNewArgument('post', 'F3\Blog\Domain\Model\Post');
	}

	/**
	 * Initializes the current action
	 *
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function initializeAction() {
		$this->URIHelper->setRequest($this->request);
	}

	/**
	 * Action that adds a comment to a blog post and redirects to single view
	 *
	 * @param \F3\Blog\Domain\Model\Comment $comment The comment to create
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function createAction(\F3\Blog\Domain\Model\Comment $comment) {
		$post = $this->arguments['post']->getValue();
		if ($this->arguments['comment']->isValid() && $post !== NULL) {
			$post->addComment($comment);
			$this->redirect($this->request->getBaseURI() . $this->URIHelper->URIFor('show', array('post' => $post), 'Posts'));
		} else {

		}

	}
}

?>
