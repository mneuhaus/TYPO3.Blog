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
	 * @var \F3\FLOW3\Security\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @inject
	 * @var  \F3\FLOW3\Security\AccountFactory
	 */
	protected $accountFactory;

	/**
	 * @inject
	 * @var \F3\FLOW3\Security\Authentication\AuthenticationManagerInterface
	 */
	protected $authenticationManager;

	/**
	 * @inject
	 * @var F3\FLOW3\Security\Context
	 */
	protected $securityContext;

	/**
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->forward($this->blogRepository->findActive() === NULL ? 'initialSetup' : 'modifySetup');
	}

	/**
	 * Sets up a fresh blog and creates a new user account.
	 *
	 * @return void
	 */
	public function initialSetupAction() {
		if ($this->blogRepository->findActive() !== NULL) {
			$this->redirect('index', 'Post');
		}

		$this->blogRepository->removeAll();

		$blog = $this->objectManager->create('F3\Blog\Domain\Model\Blog');
		$blog->setTitle('My Blog');
		$blog->setDescription('A blog about Foo, Bar and Baz.');
		$this->blogRepository->add($blog);

		$this->authenticationManager->logout();
		$this->accountRepository->removeAll();

		$account = $this->accountFactory->createAccountWithPassword('editor', 'joh316', array('Editor'));
		$this->accountRepository->add($account);

		$authenticationTokens = $this->securityContext->getAuthenticationTokensOfType('F3\FLOW3\Security\Authentication\Token\UsernamePassword');
		if (count($authenticationTokens) === 1) {
			$authenticationTokens[0]->setAccount($account);
			$authenticationTokens[0]->setAuthenticationStatus(\F3\FLOW3\Security\Authentication\TokenInterface::AUTHENTICATION_SUCCESSFUL);
		}

		$this->redirect('edit', 'Account');
	}

	/**
	 * Modify setup (to be coded)
	 *
	 * @return void
	 * @throws \LogicException
	 */
	public function modifySetupAction() {
		throw new \LogicException('No modify action coded yet', 1295879094);
	}

	/**
	 * Sets up a a blog with a lot of posts and comments which is a nice test bed
	 * for profiling.
	 *
	 * @return void
	 */
	public function profilingSetupAction() {
		if ($this->blogRepository->findActive() !== NULL) {
			$this->redirect('index', 'Post');
		}

		$this->blogRepository->removeAll();

		$postCount = 250;
		$commentCount = 0;

		$blog = $this->objectManager->create('F3\Blog\Domain\Model\Blog');
		$blog->setTitle(ucwords(\F3\Faker\Lorem::sentence(3)));
		$blog->setDescription(\F3\Faker\Lorem::sentence(8));
		$this->blogRepository->add($blog);

		$tags = array();
		foreach (range(0, 5) as $i) {
			$tags[] = $this->objectManager->create('F3\Blog\Domain\Model\Tag', \F3\Faker\Lorem::words(1));
		}

		foreach (range(1, $postCount) as $i) {
			$post = $this->objectManager->create('F3\Blog\Domain\Model\Post');
			$post->setAuthor(\F3\Faker\Name::fullName());
			$post->setTitle(trim(\F3\Faker\Lorem::sentence(3), '.'));
			$post->setContent(implode(chr(10),\F3\Faker\Lorem::paragraphs(5)));
			for ($j = 0; $j < 3; $j++) {
				$post->addTag($tags[array_rand($tags)]);
			}
			$post->setDate(\F3\Faker\Date::random('- 500 days', '+0 seconds'));
			for ($j = 0; $j < rand(0, 10); $j++) {
				$comment = $this->objectManager->create('F3\Blog\Domain\Model\Comment');
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

		return '<p>Done, created 1 blog, ' . $postCount . ' posts, ' . $commentCount . ' comments.</p>' .
				'<p><a href="' . $this->uriBuilder->uriFor('index', array(), 'Post') . '">to the post index...</a></p>';
	}

}

?>