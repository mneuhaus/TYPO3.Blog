<?php
namespace TYPO3\Blog\Domain\Model;

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

use Doctrine\ORM\Mapping as ORM;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * A blog post comment
 *
 * @FLOW3\Entity
 */
class Comment {

	/**
	 * @var \DateTime
	 * @FLOW3\Identity
	 */
	protected $date;

	/**
	 * @var \TYPO3\Blog\Domain\Model\Post
	 * @ORM\ManyToOne(inversedBy="comments")
	 */
	protected $post;

	/**
	 * @var string
	 * @FLOW3\Validate(type="Text")
	 * @FLOW3\Validate(type="StringLength", options={ "minimum"=3, "maximum"=80 })
	 * @FLOW3\Identity
	 * @ORM\Column(length=80)
	 */
	protected $author;

	/**
	 * @var string
	 * @FLOW3\Validate(type="EmailAddress")
	 */
	protected $emailAddress;

	/**
	 * @var string
	 * @FLOW3\Validate(type="NotEmpty")
	 * @ORM\Column(type="text")
	 */
	protected $content;

	/**
	 * Constructs this comment
	 *
	 */
	public function __construct() {
		$this->date = new \DateTime();
	}

	/**
	 * Setter for date
	 *
	 * @param \DateTime $date
	 * @return void
	 */
	public function setDate(\DateTime $date) {
		$this->date = $date;
	}

	/**
	 * @param \TYPO3\Blog\Domain\Model\Post $post
	 * @return void
	 */
	public function setPost(\TYPO3\Blog\Domain\Model\Post $post) {
		$this->post = $post;
	}

	/**
	 * Getter for date
	 *
	 * @return \DateTime
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Sets the author for this comment
	 *
	 * @param string $author
	 * @return void
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}

	/**
	 * Getter for author
	 *
	 * @return string
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * Sets the authors email address for this comment
	 *
	 * @param string $emailAddress email address of the author
	 * @return void
	 */
	public function setEmailAddress($emailAddress) {
		$this->emailAddress = $emailAddress;
	}

	/**
	 * Getter for authors email address
	 *
	 * @return string
	 */
	public function getEmailAddress() {
		return $this->emailAddress;
	}

	/**
	 * Sets the content for this comment
	 *
	 * @param string $content
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Getter for content
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}

}

?>