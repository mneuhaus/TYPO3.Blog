<?php
namespace F3\Blog\Service;

/*                                                                        *
 * This script belongs to the FLOW3 package "Blog".                      *
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
 * A notification service
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Notification {

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * @param \F3\Blog\Domain\Model\Comment $comment
	 * @param \F3\Blog\Domain\Model\Post $post
	 * @return void
	 */
	public function sendNewCommentNotification(\F3\Blog\Domain\Model\Comment $comment, \F3\Blog\Domain\Model\Post $post) {
		if ($this->settings['notifications']['to']['email'] === '') return;

		$mail = new \F3\SwiftMailer\Message();
		$mail
			->setFrom(array($comment->getEmailAddress() => $comment->getAuthor()))
			->setTo(array($this->settings['notifications']['to']['email'] => $this->settings['notifications']['to']['name']))
			->setSubject('New comment on blog post "' . $post->getTitle() . '"')
			->setBody($comment->getContent())
			->send();
	}

}

?>