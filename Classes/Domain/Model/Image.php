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
 * An image
 *
 * @FLOW3\Entity
 */
class Image {

	/**
	 * @var string
	 * @FLOW3\Validate(type="StringLength", options={ "maximum"=100 })
	 * @ORM\Column(length=100)
	 */
	protected $title;

	/**
	 * @var \TYPO3\FLOW3\Resource\Resource
	 * @ORM\ManyToOne
	 * FLOW3\Validate(type="NotEmpty")
	 */
	protected $originalResource;

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Gets the title
	 *
	 * @return string The title
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the original resource
	 *
	 * @param \TYPO3\FLOW3\Resource\Resource $originalResource
	 * @return void
	 */
	public function setOriginalResource(\TYPO3\FLOW3\Resource\Resource $originalResource) {
		$this->originalResource = $originalResource;
	}

	/**
	 * Returns the original resource
	 *
	 * @return \TYPO3\FLOW3\Resource\Resource $originalResource
	 */
	public function getOriginalResource() {
		return $this->originalResource;
	}
}

?>