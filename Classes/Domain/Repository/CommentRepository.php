<?php
namespace TYPO3\Blog\Domain\Repository;

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

use \TYPO3\FLOW3\Persistence\QueryInterface;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * A repository for Blog Posts
 *
 */
class CommentRepository extends \TYPO3\FLOW3\Persistence\Repository {
	/**
	 * @var \Admin\Core\Helper
	 * @author Marc Neuhaus <apocalip@gmail.com>
	 * @FLOW3\Inject
	 */
	protected $helper;
	
	var $defaultOrderings = array(
		"date" => "DESC"
	);
	
	/**
	 * Schedules a modified object for persistence.
	 *
	 * @param object $object The modified object
	 * @throws \TYPO3\FLOW3\Persistence\Exception\IllegalObjectTypeException
	 * @api
	 */
	public function add($object) {
		if(!$this->helper->isDemoMode() || $this->helper->isUserSuperAdmin())
			parent::add($object);
	}
	
	/**
	 * Schedules a modified object for persistence.
	 *
	 * @param object $object The modified object
	 * @throws \TYPO3\FLOW3\Persistence\Exception\IllegalObjectTypeException
	 * @api
	 */
	public function update($object) {
		if(!$this->helper->isDemoMode() || $this->helper->isUserSuperAdmin())
			parent::update($object);
	}
	
	/**
	 * Schedules a modified object for persistence.
	 *
	 * @param object $object The modified object
	 * @throws \TYPO3\FLOW3\Persistence\Exception\IllegalObjectTypeException
	 * @api
	 */
	public function remove($object) {
		if(!$this->helper->isDemoMode() || $this->helper->isUserSuperAdmin())
			parent::remove($object);
	}
}
?>