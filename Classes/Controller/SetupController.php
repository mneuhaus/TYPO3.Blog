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
 * The setup controller for the Blog package, currently just setting up some
 * data to play with.
 *
 * @package Blog
 * @subpackage Controller
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class SetupController extends \F3\FLOW3\MVC\Controller\ActionController {

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
	 * Index action for this controller
	 *
	 * @return string
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function indexAction() {
		foreach ($this->blogRepository->findAll() as $blog) {
			$this->blogRepository->remove($blog);
		}

		$blog = $this->objectFactory->create('F3\Blog\Domain\Model\Blog');
		$blog->setName('flow3');
		$blog->setDescription('A blog about FLOW3 development.');

		$post = $this->objectFactory->create('F3\Blog\Domain\Model\Post');
		$post->setAuthor('John Doe');
		$post->setTitle('about persistence and lorem ipsum');
		$post->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
		$post->setPublished(TRUE);
		$post->setVotes(5);

		$this->postRepository->add($post);

		$blog->addPost($post);
		$this->blogRepository->add($blog);
		return 'Some data has been added to the BlogRepository...';
	}

}

?>