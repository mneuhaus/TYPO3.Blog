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
	 * @var \F3\Party\Domain\Repository\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @inject
	 * @var \F3\FLOW3\Security\Authentication\AuthenticationManagerInterface
	 */
	protected $authenticationManager;

	/**
	 * @inject
	 * @var F3\FLOW3\Security\ContextHolderInterface
	 */
	protected $securityContextHolder;

	/**
	 *
	 * @return unknown_type
	 */
	public function indexAction() {
		$this->forward($this->blogRepository->findActive() === FALSE ? 'initialSetup' : 'modifySetup');
	}

	/**
	 * Sets up a fresh blog and creates a new user account.
	 *
	 * @return void
	 */
	public function initialSetupAction() {
		if ($this->blogRepository->findActive() !== FALSE) {
#			$this->redirect('index', 'Post');
		}

		$this->blogRepository->removeAll();

		$blog = $this->objectFactory->create('F3\Blog\Domain\Model\Blog');
		$blog->setTitle('My Blog');
		$blog->setDescription('A blog about Foo, Bar and Baz.');
		$this->blogRepository->add($blog);

#		$tag = $this->objectFactory->create('F3\Blog\Domain\Model\Tag', 'FooBar');
#		$post = $this->objectFactory->create('F3\Blog\Domain\Model\Post');
#		$post->setAuthor('John Doe');
#		$post->setTitle('Example Post');
#		$post->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
#		$post->addTag($tag);

#		$blog->addPost($post);

		$account = $this->objectFactory->create('F3\Party\Domain\Model\Account');
		$credentials = md5(md5('joh316') . 'someSalt') . ',someSalt';

		$roles = array(
			$this->objectFactory->create('F3\FLOW3\Security\Policy\Role', 'Editor'),
		);

		$this->authenticationManager->logout();
		$this->accountRepository->removeAll();

		$account->setAccountIdentifier('editor');
		$account->setCredentialsSource($credentials);
		$account->setAuthenticationProviderName('DefaultProvider');
		$account->setRoles($roles);

		$this->accountRepository->add($account);

		$authenticationTokens = $this->securityContextHolder->getContext()->getAuthenticationTokensOfType('F3\FLOW3\Security\Authentication\Token\UsernamePassword');
		if (count($authenticationTokens) === 1) {
			$authenticationTokens[0]->setAccount($account);
			$authenticationTokens[0]->setAuthenticationStatus(\F3\FLOW3\Security\Authentication\TokenInterface::AUTHENTICATION_SUCCESSFUL);
		}

		$this->redirect('edit', 'Account');
	}

	/**
	 * Sets up a a blog with a lot of posts and comments which is a nice test bed
	 * for profiling.
	 *
	 * @return void
	 */
	public function profilingSetupAction() {
		if ($this->blogRepository->findActive() !== FALSE) {
			$this->redirect('index', 'Post');
		}

		$this->blogRepository->removeAll();

		$postCount = 250;
		$commentCount = 0;

		$blog = $this->objectFactory->create('F3\Blog\Domain\Model\Blog');
		$blog->setTitle(ucwords(\F3\Faker\Lorem::sentence(3)));
		$blog->setDescription(\F3\Faker\Lorem::sentence(8));
		$this->blogRepository->add($blog);

		$tags = array();
		foreach (range(0, 5) as $i) {
			$tags[] = $this->objectFactory->create('F3\Blog\Domain\Model\Tag', \F3\Faker\Lorem::words(1));
		}

		foreach (range(1, $postCount) as $i) {
			$post = $this->objectFactory->create('F3\Blog\Domain\Model\Post');
			$post->setAuthor(\F3\Faker\Name::fullName());
			$post->setTitle(trim(\F3\Faker\Lorem::sentence(3), '.'));
			$post->setContent(implode(chr(10),\F3\Faker\Lorem::paragraphs(5)));
			for ($j = 0; $j < 3; $j++) {
				$post->addTag($tags[array_rand($tags)]);
			}
			$post->setDate(\F3\Faker\Date::random('- 500 days', '+0 seconds'));
			for ($j = 0; $j < rand(0, 10); $j++) {
				$comment = $this->objectFactory->create('F3\Blog\Domain\Model\Comment');
				$comment->setAuthor(\F3\Faker\Name::fullName());
				$comment->setEmailAddress(\F3\Faker\Internet::email());
				$comment->setContent(implode(chr(10),\F3\Faker\Lorem::paragraphs(2)));
				$comment->setDate(\F3\Faker\Date::random('+ 10 minutes', '+ 6 weeks', $post->getDate()));
				$post->addComment($comment);
				$commentCount++;
			}

			$blog->addPost($post);
		}

		$account = $this->objectFactory->create('F3\Party\Domain\Model\Account');
		$credentials = md5(md5('joh316') . 'someSalt') . ',someSalt';

		$roles = array(
			$this->objectFactory->create('F3\FLOW3\Security\Policy\Role', 'Editor'),
		);

		$this->authenticationManager->logout();
		$this->accountRepository->removeAll();

		$account->setAccountIdentifier('robert');
		$account->setCredentialsSource($credentials);
		$account->setAuthenticationProviderName('DefaultProvider');
		$account->setRoles($roles);

		$this->accountRepository->add($account);

		return '<p>Done, created 1 blog, ' . $postCount . ' posts, ' . $commentCount . ' comments.</p>';

		$this->redirect('index', 'Post');
	}

}

?>