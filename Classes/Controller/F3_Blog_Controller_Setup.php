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
		$tag1 = $this->componentFactory->getComponent('F3_Blog_Domain_Tag');
		$tag1->setName('Development');
		$tag2 = $this->componentFactory->getComponent('F3_Blog_Domain_Tag');
		$tag2->setName('PHP');
		$tag3 = $this->componentFactory->getComponent('F3_Blog_Domain_Tag');
		$tag3->setName('Java');

		$comment = $this->componentFactory->getComponent('F3_Blog_Domain_Comment');
		$comment->setAuthor('Jane Done');
		$comment->setContent('Lest lieber BILDblog!');

		$post1 = $this->componentFactory->getComponent('F3_Blog_Domain_Post');
		$post1->setAuthor('John Doe');
		$post1->setTitle('About persistence and Lorem Ipsum');
		$post1->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
		$post1->addTag($tag1);
		$post1->addTag($tag2);
		$post1->addComment($comment);

		$post2 = $this->componentFactory->getComponent('F3_Blog_Domain_Post');
		$post2->setAuthor('Jimmy Nilsson');
		$post2->setTitle('Why DDD matters');
		$post2->setContent('On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain.');
		$post2->addTag($tag1);
		$post2->addTag($tag3);

		$post3 = $this->componentFactory->getComponent('F3_Blog_Domain_Post');
		$post3->setAuthor('Robert Lemke');
		$post3->setTitle('Why FLOW3 rocks');
		$post3->setContent('It can change the way you work. It gives you fast results. It is a reliable foundation for complex applications. And it is backed by one of the biggest PHP communities.');
		$post3->addTag($tag2);
		$post3->addTag($tag3);

		$blog = $this->componentFactory->getComponent('F3_Blog_Domain_Blog', 'FLOW3');
		$blog->addPost($post1);
		$blog->addPost($post2);
		$blog->addPost($post3);

		$this->blogRepository->add($blog);

		return 'Some data has been added to the BlogRepository...';
	}

}

?>