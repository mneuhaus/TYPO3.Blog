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
	 * @var \F3\FLOW3\MVC\Web\Routing\URIBuilder
	 */
	protected $URIBuilder;

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
		$this->URIBuilder->setRequest($this->request);
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
