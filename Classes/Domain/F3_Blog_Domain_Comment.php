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
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @entity
 */
class F3_Blog_Domain_Comment {

	/**
	 * @var DateTime
	 */
	protected $date;

	/**
	 * @var string
	 */
	protected $author;

	/**
	 * @var string
	 */
	protected $content;

	/**
	 * Setter for date
	 *
	 * @param string $date
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setDate($date) {
		$this->date = $date;
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
	 * Returns this comment as a formatted string
	 *
	 * @return string
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function __toString() {
		return $this->author . ' said on ' . date('Y-m-d', $this->date) . ':' . chr(10) .
			$this->content . chr(10);
	}
}
?>