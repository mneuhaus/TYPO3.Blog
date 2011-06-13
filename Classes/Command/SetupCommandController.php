<?php
namespace F3\Blog\Command;

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
 * The setup controller for the Blog package, for setting up some
 * data to play with.
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @scope singleton
 */
class SetupCommandController extends \F3\FLOW3\MVC\Controller\CommandController {

	/**
	 * @inject
	 * @var \F3\Blog\Domain\Repository\BlogRepository
	 */
	protected $blogRepository;

	/**
	 * @inject
	 * @var \F3\Blog\Domain\Repository\CategoryRepository
	 */
	protected $categoryRepository;

	/**
	 * @inject
	 * @var \F3\Party\Domain\Repository\PersonRepository
	 */
	protected $personRepository;

	/**
	 * @inject
	 * @var \F3\FLOW3\Security\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @inject
	 * @var \F3\FLOW3\Security\AccountFactory
	 */
	protected $accountFactory;

	/**
	 * @inject
	 * @var \F3\FLOW3\Security\Authentication\AuthenticationManagerInterface
	 */
	protected $authenticationManager;

	/**
	 * Sets up a a blog with a lot of posts and comments which is a nice test bed
	 * for profiling.
	 *
	 * @param integer $postCount
	 * @param integer $tagCount
	 * @param integer $categoryCount
	 * @return string
	 */
	public function profilingDataCommand($postCount = 250, $tagCount = 5, $categoryCount = 5) {
		$this->blogRepository->removeAll();

		$commentCount = 0;

		$blog = new \F3\Blog\Domain\Model\Blog();
		$blog->setTitle(ucwords(\F3\Faker\Lorem::sentence(3)));
		$blog->setDescription(\F3\Faker\Lorem::sentence(8));
		$this->blogRepository->add($blog);

		$authors = array();
		for ($i = 0; $i < 10; $i++) {
			$authors[] = \F3\Faker\Name::fullName();
		}

		$tags = array();
		for ($i = 0; $i < $tagCount; $i++) {
			$tags[] = new \F3\Blog\Domain\Model\Tag(\F3\Faker\Lorem::words(1));
		}

		$categories = array();
		for ($i = 0; $i < $categoryCount; $i++) {
			$category = new \F3\Blog\Domain\Model\Category();
			$category->setName(\F3\Faker\Lorem::words(1));
			$categories[] = $category;
			$this->categoryRepository->add($category);
		}

		for ($i = 0; $i < $postCount; $i++) {
			$post = new \F3\Blog\Domain\Model\Post();
			$post->setAuthor($authors[array_rand($authors)]);
			$post->setTitle(trim(\F3\Faker\Lorem::sentence(3), '.'));
			$post->setContent(implode(chr(10),\F3\Faker\Lorem::paragraphs(5)));
			$post->addTag($tags[array_rand($tags)]);
			$post->setCategory($categories[array_rand($categories)]);
			$post->setDate(\F3\Faker\Date::random('- 500 days', '+0 seconds'));
			for ($j = 0; $j < rand(0, 10); $j++) {
				$comment = new \F3\Blog\Domain\Model\Comment();
				$comment->setAuthor(\F3\Faker\Name::fullName());
				$comment->setEmailAddress(\F3\Faker\Internet::email());
				$comment->setContent(implode(chr(10),\F3\Faker\Lorem::paragraphs(2)));
				$comment->setDate(\F3\Faker\Date::random('+ 10 minutes', '+ 6 weeks', $post->getDate()));
				$post->addComment($comment);
				$commentCount++;
			}

			$blog->addPost($post);
		}

		$this->authenticationManager->logout();
		$this->accountRepository->removeAll();

		$account = $this->accountFactory->createAccountWithPassword('editor', 'joh316', array('Editor'));
		$this->accountRepository->add($account);

		$personName = new \F3\Party\Domain\Model\PersonName('', \F3\Faker\Name::firstName(), '', \F3\Faker\Name::lastName());
		$person = new \F3\Party\Domain\Model\Person();
		$person->setName($personName);
		$person->addAccount($account);
		$this->personRepository->add($person);

		return 'Done, created 1 blog, ' . $postCount . ' posts, ' . $commentCount . ' comments.';
	}
}
?>