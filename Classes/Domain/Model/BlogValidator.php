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
 * A Blogvalidator
 *
 * @package Blog
 * @subpackage Domain
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @scope singleton
 */
class BlogValidator extends \F3\FLOW3\Validation\Validator\AbstractValidator {

	/**
	 * If the given blog is valid
	 *
	 * @param \F3\Blog\Domain\Model\Blog $blog The blog
	 * @return boolean true
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function isValid($blog) {
		if (!$blog instanceof \F3\Blog\Domain\Model\Blog) {
			$this->addError('The blog is not a blog', 1);
			return FALSE;
		}
		if ($blog->getName() === 'FLOW3') {
			$this->addError('"FLOW3" can\'t be used as a blog name.', 2);
			return FALSE;
		}
		return TRUE;
	}

}
?>