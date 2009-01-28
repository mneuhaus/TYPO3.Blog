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
	 * @var \F3\Blog\Domain\BlogRepository
	 */
	protected $blogRepository;

	/**
	 * @var \F3\Blog\Domain\Blog
	 */
	protected $blog;

	/**
	 * Injects the BlogRepository
	 * 
	 * @param \F3\Blog\Domain\BlogRepository $blogRepository
	 * @return void
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function injectBlogRepository(\F3\Blog\Domain\BlogRepository $blogRepository) {
		$this->blogRepository = $blogRepository;
		$blogs = $this->blogRepository->findByName('FLOW3');
		if (count($blogs) && $blogs[0] instanceof \F3\Blog\Domain\Blog) {
			$this->blog = $blogs[0];
		}
	}

	/**
	 * Checks whether $value is an existing post title.
	 * 
	 * @param string $value to match
	 * @return boolean TRUE if post could be found
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	protected function matchValue($value) {
		if (!parent::matchValue($value)) {
			return FALSE;
		}

		$postTitle = str_replace('-', ' ', $this->value);
		$post = $this->blog->findPostByTitle($postTitle);
		if ($post === NULL) {
			$this->value = NULL;
			return FALSE;
		}
		$this->value = $post->getIdentifier();
		return TRUE;
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
		$post = $this->blog->findPostByIdentifier($postUUID);
		if ($post === NULL) {
			$this->value = NULL;
			return FALSE;
		}
		$this->value = str_replace(' ', '-', $post->getTitle());
		return TRUE;
	}
}
?>