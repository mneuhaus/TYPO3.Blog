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
 * @subpackage Tests
 * @version $Id$
 */

/**
 * @package Blog
 * @subpackage Tests
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class F3_Blog_BlogRepositoryTest extends F3_Testing_BaseTestCase {

	/**
	 * Make sure BlogRepository is singleton
	 *
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @test
	 */
	public function blogRepositoryIsSingleton() {
		$firstInstance = $this->componentFactory->getComponent('F3_Blog_Domain_BlogRepository');
		$secondInstance = $this->componentFactory->getComponent('F3_Blog_Domain_BlogRepository');
		$this->assertSame($secondInstance, $firstInstance, 'F3_Blog_Domain_BlogRepository is not prototype.');
	}

	/**
	 * Check that a blog can be found by name
	 *
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @test
	 */
	public function blogsAddedToTheBlogRepositoryCanBeFoundByName() {
		$blog1 = new F3_Blog_Domain_Blog('FLOW1');
		$blog2 = new F3_Blog_Domain_Blog('FLOW2');
		$blog3 = new F3_Blog_Domain_Blog('FLOW3');
		$blog4 = new F3_Blog_Domain_Blog('FLOW4');
		$blogRepository = new F3_Blog_Domain_BlogRepository();
		$blogRepository->add($blog1);
		$blogRepository->add($blog2);
		$blogRepository->add($blog3);
		$blogRepository->add($blog4);
		$foundBlog = $blogRepository->findByName('FLOW3');
		$this->assertSame($blog3, $foundBlog, 'The blog could not be found by findByName.');
	}
}

?>