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
 * The setup controller for the Blog package, currently just setting up some
 * data to play with.
 *
 * @package Blog
 * @subpackage Controller
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class F3_Blog_Controller_Setup extends F3_FLOW3_MVC_Controller_ActionController {

	/**
	 * @var F3_Blog_Domain_BlogRepository
	 */
	protected $blogRepository;

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
		$this->supportedRequestTypes = array('F3_FLOW3_MVC_Web_Request', 'F3_FLOW3_MVC_CLI_Request');
	}

	/**
	 * Default action for this controller
	 *
	 * @return string
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function defaultAction() {
		$blog = $this->componentFactory->getComponent('F3_Blog_Domain_Blog', 'FLOW3');

		$post = $this->componentFactory->getComponent('F3_Blog_Domain_Post');
		$post->setAuthor('John Doe');
		$post->setTitle('About persistence and Lorem Ipsum');
		$post->setContent('Lorem ipsum dolor sit amet...');

		$tag1 = $this->componentFactory->getComponent('F3_Blog_Domain_Tag');
		$tag1->setName('Development');
		$tag2 = $this->componentFactory->getComponent('F3_Blog_Domain_Tag');
		$tag2->setName('PHP');

		$comment = $this->componentFactory->getComponent('F3_Blog_Domain_Comment');
		$comment->setAuthor('Jane Done');
		$comment->setContent('Lest lieber BILDblog!');

		$post->addTag($tag1);
		$post->addTag($tag2);
		$post->addComment($comment);
		$blog->addPost($post);
		$this->blogRepository->add($blog);

		return 'Some data has been added to the BlogRepository...';
	}

}

?>