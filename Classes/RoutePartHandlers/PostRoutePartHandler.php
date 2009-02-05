<?php
declare(ENCODING = 'utf-8');
namespace F3\Blog\RoutePartHandlers;

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
 * @package FLOW3
 * @subpackage MVC
 * @version $Id$
 */

/**
 * post route part handler
 *
 * @package FLOW3
 * @subpackage MVC
 * @version $Id$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 */
class PostRoutePartHandler extends \F3\FLOW3\MVC\Web\Routing\DynamicRoutePart {

	/**
	 * @inject
	 * @var \F3\Blog\Domain\PostRepository
	 */
	protected $postRepository;

	/**
	 * @inject
	 * @var \F3\FLOW3\Cache\Frontend\VariableFrontend
	 */
	protected $mappingCache;

	/**
	 * @var array
	 */
	protected $mapping = array();

	/**
	 * Initializes the object
	 *
	 * @return void
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function initializeObject() {
		if ($this->mappingCache->has('map')) {
			$this->mapping = $this->mappingCache->get('map');
		}
	}

	/**
	 * Checks whether $value is an existing post title.
	 *
	 * @param string $value to match
	 * @return boolean TRUE if post could be found
	 * @author Bastian Waidelich <bastian@typo3.org>
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	protected function matchValue($value) {
		if (!parent::matchValue($value)) {
			return FALSE;
		}

		$postUUID = array_search($this->value, $this->mapping);
		if ($postUUID !== FALSE) {
			$this->value = $postUUID;
			return TRUE;
		} else {
			$this->value = NULL;
			return FALSE;
		}
	}

	/**
	 * Checks whether $value is a valid post UUID.
	 *
	 * @param string $value to resolve
	 * @return boolean TRUE if post could be found
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	protected function resolveValue($value) {
		if (!parent::resolveValue($value)) {
			return FALSE;
		}

		$postUUID = $this->value;
		if (isset($this->mapping[$postUUID])) {
			$this->value = $this->mapping[$postUUID];
			return TRUE;
		} else {
			$post = $this->postRepository->findByUUID($postUUID);
			if ($post === NULL) {
				$this->value = NULL;
				return FALSE;
			} else {
				$this->value = strtolower(str_replace(' ', '-', $post->getTitle()));
				$this->mapping[$postUUID] = $this->value;
				$this->mappingCache->set('map', $this->mapping);
				return TRUE;
			}
		}
	}
}
?>