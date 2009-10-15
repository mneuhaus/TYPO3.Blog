<?php
declare(ENCODING = 'utf-8');
namespace F3\Blog\Controller;

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

/**
 * The setup controller for the Blog package, currently just setting up some
 * data to play with.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SetupController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * @inject
	 * @var \F3\Blog\Domain\Repository\BlogRepository
	 */
	protected $blogRepository;

	/**
	 * @inject
	 * @var \F3\Blog\Domain\Repository\PostRepository
	 */
	protected $postRepository;

	/**
	 * Index action for this controller
	 *
	 * @return string
	 */
	public function indexAction() {
		$this->blogRepository->removeAll();

		$blogCount = $postCount = $commentCount = 0;
		$startTime = microtime(TRUE);
		foreach (range(1, rand(1, 5)) as $b) {
			$blogCount++;
			$blog = $this->objectFactory->create('F3\Blog\Domain\Model\Blog');
			$blog->setIdentifier('blog' . $b);
			$blog->setTitle(ucwords(\F3\Faker\Lorem::sentence(3)));
			$blog->setDescription(\F3\Faker\Lorem::sentence());
			$this->blogRepository->add($blog);

			$tags = array();
			foreach (range(0, rand(3, 5)) as $i) {
				$tags[] = $this->objectFactory->create('F3\Blog\Domain\Model\Tag', \F3\Faker\Lorem::words(1));
			}

			foreach (range(1, rand(15, 25)) as $i) {
				$postCount++;
				$post = $this->objectFactory->create('F3\Blog\Domain\Model\Post');
				$post->setAuthor(\F3\Faker\Name::fullName());
				$post->setTitle(trim(\F3\Faker\Lorem::sentence(2), '.'));
				$post->setContent(implode(chr(10),\F3\Faker\Lorem::paragraphs(5)));
				for ($j = 0; $j < rand(0, 5); $j++) {
					$post->addTag($tags[array_rand($tags)]);
				}
				$post->setDate(\F3\Faker\Date::random('- 500 days', '+0 seconds'));
				for ($j = 0; $j < rand(0, 10); $j++) {
					$commentCount++;
					$comment = $this->objectFactory->create('F3\Blog\Domain\Model\Comment');
					$comment->setAuthor(\F3\Faker\Name::fullName());
					$comment->setEmailAddress(\F3\Faker\Internet::email());
					$comment->setContent(implode(chr(10),\F3\Faker\Lorem::paragraphs(2)));
					$comment->setDate(\F3\Faker\Date::random('+ 10 minutes', '+ 6 weeks', $post->getDate()));
					$post->addComment($comment);
				}

				$blog->addPost($post);
			}
		}
		$endTime = microtime(TRUE);

		return '<p>Done, created ' . $blogCount . ' blogs, ' . $postCount . ' posts, ' . $commentCount . ' comments.</p>' .
		'<p>Peak memory usage was ~' . floor(memory_get_peak_usage()/1024/1024) . ' MByte.<br />' .
		'Data generation took ' . round(($endTime - $startTime), 4) . ' seconds.</p>';
	}

}

?>