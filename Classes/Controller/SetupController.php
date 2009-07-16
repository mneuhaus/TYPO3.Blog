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
 * The setup controller for the Blog package, currently just setting up some
 * data to play with.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SetupController extends \F3\FLOW3\MVC\Controller\ActionController {

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
		$blog->setName('FLOW3' . time());
		$blog->setDescription('A blog about FLOW3 development.');

		$tag = $this->objectFactory->create('F3\Blog\Domain\Model\Tag', 'FooBar');
		for ($i=0; $i < 100; $i++) {
			$post = $this->objectFactory->create('F3\Blog\Domain\Model\Post');
			$post->setAuthor('John Doe');
			$post->setTitle('Example Post ' . $i);
			$post->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
			$post->setPublished(TRUE);
			$post->setVotes(5);
			$post->addTag($tag);

			$this->postRepository->add($post);
			$blog->addPost($post);
		}
		$this->blogRepository->add($blog);
		#$this->redirect('index', 'blog');
		return 'done';
	}

}

?>