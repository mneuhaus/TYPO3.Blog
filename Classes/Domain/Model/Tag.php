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
 * A blog post tag
 *
 * @FLOW3\ValueObject
 */
class Tag {

	/**
	 * @var string
	 * @FLOW3\Validate(type="Alphanumeric")
	 * @FLOW3\Validate(type="StringLength", options={ "minimum"=1, "maximum"=20 })
	 * @ORM\Column(length=20)
	 */
	protected $name;

	/**
	 * The posts tagged with this tag
	 *
	 * @var \Doctrine\Common\Collections\Collection<\TYPO3\Blog\Domain\Model\Post>
	 * @ORM\ManyToMany(mappedBy="tags")
	 */
	protected $posts;

	/**
	 * Constructs this tag
	 *
	 * @param string $name
	 */
	public function __construct($name) {
		$this->name = $name;
		$this->posts = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Returns this tag's name
	 *
	 * @return string This tag's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns this tag as a string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->name;
	}
}
?>