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
 * A blog
 *
 * @package Blog
 * @subpackage Domain
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Blog implements \F3\FLOW3\Persistence\Aspect\DirtyMonitoringInterface {

	/**
	 * The blog's name. Also acts as the identifier.
	 *
	 * @var string
	 * @validate Alphanumeric, StringLength(minimum = 3, maximum = 50)
	 * @identity
	 */
	protected $name = '';

	/**
	 * A short description of the blog
	 *
	 * @var string
	 * @validate Text, StringLength(maximum = 150)
	 */
	protected $description = '';

	/**
	 * The blog's logo
	 *
	 * @var string
	 */
	protected $logo;

	/**
	 * The posts contained in this blog
	 *
	 * @var \SplObjectStorage
	 * @lazy
	 */
	protected $posts;

	/**
	 * @var boolean
	 * @transient
	 */
	protected $isNew;

	/**
	 * @var boolean
	 * @transient
	 */
	protected $isDirty;

	/**
	 * Constructs a new Blog
	 *
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function __construct() {
		$this->isNew = TRUE;
		$this->posts = new \SplObjectStorage();
	}

	/**
	 * Sets this blog's name
	 *
	 * @param string $name The blog's name
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function setName($name) {
		$this->isDirty = TRUE;
		$this->name = $name;
	}

	/**
	 * Returns the blog's name
	 *
	 * @return string The blog's name
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the description for the blog
	 *
	 * @param string $description
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setDescription($description) {
		$this->isDirty = TRUE;
		$this->description = $description;
	}

	/**
	 * Returns the description
	 *
	 * @return string
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Adds a post to this blog
	 *
	 * @param \F3\Blog\Domain\Model\Post $post
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function addPost(\F3\Blog\Domain\Model\Post $post) {
		$this->isDirty = TRUE;
		$post->setBlog($this);
		$this->posts->attach($post);
	}

	/**
	 * Returns all posts in this blog
	 *
	 * @return \SplObjectStorage
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getPosts() {
		if ($this->posts instanceof \F3\FLOW3\Persistence\LazyLoadingProxy) {
			$this->posts->_loadRealInstance();
		}
		return clone $this->posts;
	}

	/**
	 * If the monitored object has ever been persisted
	 *
	 * @return boolean TRUE if the object is new, otherwise FALSE
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function FLOW3_Persistence_isNew() {
		return $this->isNew;
	}

	/**
	 * If the specified property of the reconstituted object has been modified
	 * since it woke up.
	 *
	 * @param string $propertyName Name of the property to check
	 * @return boolean TRUE if the given property has been modified
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function FLOW3_Persistence_isDirty($propertyName) {
		return $this->isDirty;
	}

	/**
	 * Resets the dirty flags of all properties to signal that the object is
	 * clean again after being persisted.
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function FLOW3_Persistence_memorizeCleanState() {
		$this->isDirty = FALSE;
		$this->isNew = FALSE;
	}

	/**
	 * Introduces a clone method
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function __clone() {
		$this->isDirty = FALSE;
		$this->isNew = TRUE;
	}

}
?>