<?php
declare(ENCODING = 'utf-8');
namespace F3\Blog\Domain\Model;

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
 * @subpackage Domain
 * @version $Id$
 */

/**
 * A blog post comment
 *
 * @package Blog
 * @subpackage Domain
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @scope prototype
 * @entity
 */
class Comment {

	/**
	 * @var \DateTime
	 */
	protected $date;

	/**
	 * @var string
	 */
	protected $author;

	/**
	 * @var string
	 */
	protected $emailAddress;

	/**
	 * @var string
	 */
	protected $content;

	/**
	 * Constructs this comment
	 *
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function __construct() {
		$this->date = new \DateTime();
	}

	/**
	 * Setter for date
	 *
	 * @param \DateTime $date
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setDate(\DateTime $date) {
		$this->date = $date;
	}

	/**
	 * Getter for date
	 *
	 * @return \DateTime
	 * @author Matthias Hoermann <hoermann@saltation.de>
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Sets the author for this comment
	 *
	 * @param string $author
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}

	/**
	 * Getter for author
	 *
	 * @return string
	 * @author Matthias Hoermann <hoermann@saltation.de>
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * Sets the authors email for this comment
	 *
	 * @param string $emailAddress email of the author
	 * @return void
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function setEmailAddress($emailAddress) {
		$this->emailAddress = $emailAddress;
	}

	/**
	 * Getter for authors email
	 *
	 * @return string
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function getEmailAddress() {
		return $this->emailAddress;
	}

	/**
	 * Sets the content for this comment
	 *
	 * @param string $content
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Getter for content
	 *
	 * @return string
	 * @author Matthias Hoermann <hoermann@saltation.de>
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Returns this comment as a formatted string
	 *
	 * @return string
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function __toString() {
		return $this->author . ' (' . $this->email . ') said on ' . $this->date->format('Y-m-d') . ':' . chr(10) .
			$this->content . chr(10);
	}
}
?>
