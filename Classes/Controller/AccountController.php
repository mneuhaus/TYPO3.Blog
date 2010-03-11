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
 * The account controller for the Blog package
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AccountController extends \F3\Blog\Controller\AbstractBaseController {

	/**
	 * @inject
	 * @var \F3\FLOW3\Security\AccountRepository
	 */
	protected $accountRepository;

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
	 * List action for this controller.
	 *
	 * @return string
	 */
	public function indexAction() {
		$this->forward('edit');
	}

	/**
	 * Displays a form for setting a new password and / or username
	 *
	 * @return string An HTML form for editing the account properties
	 */
	public function editAction() {
		$activeTokens = $this->securityContext->getAuthenticationTokens();
		foreach ($activeTokens as $token) {
			if ($token->isAuthenticated()) {
				$account = $token->getAccount();
				$this->view->assign('account', $account);
			}
		}
	}

	/**
	 * Updates the account properties
	 *
	 * @param F3\FLOW3\Security\Account $account
	 * @param string $password
	 * @return void
	 */
	public function updateAction(\F3\FLOW3\Security\Account $account, $password = '') {
		if ($password != '') {
			$salt = substr(md5(uniqid(rand(), TRUE)), 0, rand(6, 10));
			$account->setCredentialsSource(md5(md5($password) . $salt) . ',' . $salt);
		}

		$this->accountRepository->update($account);
		$this->flashMessageContainer->add('Your account details have been updated.');
		$this->redirect('index', 'Admin');
	}
}
?>