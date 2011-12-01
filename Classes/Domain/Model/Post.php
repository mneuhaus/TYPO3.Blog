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
use Admin\Annotations as Admin;

/**
 * A blog post
 *
 * @FLOW3\Entity
 * @Admin\Active
 */
class Post {

	/**
	 * @var \TYPO3\Blog\Domain\Model\Blog
	 * @ORM\ManyToOne(inversedBy="posts")
	 */
	protected $blog;

	/**
	 * @var string
	 * @FLOW3\Validate(type="StringLength", options={ "minimum"=1, "maximum"=100 })
	 * @FLOW3\Identity
	 * @ORM\Column(length=100)
	 */
	protected $title;

	/**
	 * @FLOW3\Identity
	 * @var \DateTime
	 */
	protected $date;

	/**
	 * @var string
	 * @FLOW3\Validate(type="StringLength", options={ "minimum"=1, "maximum"=50 })
	 * @ORM\Column(length=50)
	 */
	protected $author;

	/**
	 * @var string
	 * @ORM\Column(type="text")
	 * @FLOW3\Validate(type="Raw")
	 * @Admin\Ignore("list")
	 * @Admin\Editor("Markdown")
	 */
	protected $content;

	/**
	 * @var \TYPO3\Blog\Domain\Model\Image
	 * @ORM\ManyToOne
	 * @Admin\Ignore("list")
	 * @Admin\Inline
	 */
	protected $image;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\TYPO3\Blog\Domain\Model\Tag>
	 * @ORM\ManyToMany(inversedBy="posts")
	 * @Admin\Ignore
	 */
	protected $tags;

	/**
	 * @var \TYPO3\Blog\Domain\Model\Category
	 * @ORM\ManyToOne
	 * @Admin\Ignore("list")
	 * @Admin\Widget("Chosen")
	 */
	protected $category;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\TYPO3\Blog\Domain\Model\Comment>
	 * @ORM\OneToMany(mappedBy="post")
	 * @ORM\OrderBy({"date" = "DESC"})
	 * @Admin\Ignore("list")
	 * @Admin\Inline
	 * @Admin\Variant("Tabular")
	 */
	protected $comments;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\TYPO3\Blog\Domain\Model\Post>
	 * @ORM\ManyToMany
	 * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(name="related_id")})
	 * @Admin\Ignore("list")
	 */
	protected $relatedPosts;

	/**
	 * Constructs this post
	 */
	public function __construct() {
		$this->date = new \DateTime();
		$this->comments = new \Doctrine\Common\Collections\ArrayCollection();
		$this->relatedPosts = new \Doctrine\Common\Collections\ArrayCollection();
		$this->tags = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	public function __toString(){
		return $this->getTitle();
	}

	/**
	 * Sets the blog this post is part of
	 *
	 * @param \TYPO3\Blog\Domain\Model\Blog $blog The blog
	 * @return void
	 */
	public function setBlog(\TYPO3\Blog\Domain\Model\Blog $blog) {
		$this->blog = $blog;
	}

	/**
	 * Returns the blog this post is part of
	 *
	 * @return \TYPO3\Blog\Domain\Model\Blog The blog this post is part of
	 */
	public function getBlog() {
		return $this->blog;
	}

	/**
	 * Setter for title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Getter for title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
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
	 * Getter for date
	 *
	 * @return \DateTime
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Getter for image
	 *
	 * @return TYPO3\Blog\Domain\Model\Image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Setter for image
	 *
	 * @param TYPO3\Blog\Domain\Model\Image $image
	 */
	public function setImage(\TYPO3\Blog\Domain\Model\Image $image = NULL) {
			// work around property mapper delivering an empty Image
		if ($image === NULL || $image->getOriginalResource() !== NULL) {
			$this->image = $image;
		}
	}

	/**
	 * Setter for tags
	 *
	 * @param \Doctrine\Common\Collections\Collection<\TYPO3\Blog\Domain\Model\Tag> $tags The tags
	 * @return void
	 */
	public function setTags(\Doctrine\Common\Collections\Collection $tags) {
		$this->tags = clone $tags;
	}

	/**
	 * Adds a tag to this post
	 *
	 * @param \TYPO3\Blog\Domain\Model\Tag $tag
	 * @return void
	 */
	public function addTag(\TYPO3\Blog\Domain\Model\Tag $tag) {
		$this->tags->add($tag);
	}

	/**
	 * Getter for tags
	 *
	 * @return \Doctrine\Common\Collections\Collection<\TYPO3\Blog\Domain\Model\Tag> The tags
	 */
	public function getTags() {
		return clone $this->tags;
	}

	/**
	 * Sets the author for this post
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
	 * Sets the content for this post
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
	
	/**
	 * Adds a comment to this post
	 *
	 * @param \TYPO3\Blog\Domain\Model\Comment $comment
	 * @return void
	 */
	public function setComments($comments) {
		$this->comments = $comments;
	}
	
	/**
	 * Adds a comment to this post
	 *
	 * @param \TYPO3\Blog\Domain\Model\Comment $comment
	 * @return void
	 */
	public function addComment(\TYPO3\Blog\Domain\Model\Comment $comment) {
		$comment->setPost($this);
		$this->comments->add($comment);
	}

	/**
	 * Removes a comment from this post
	 *
	 * @param \TYPO3\Blog\Domain\Model\Comment $comment
	 * @return void
	 */
	public function removeComment(\TYPO3\Blog\Domain\Model\Comment $comment) {
		$this->comments->removeElement($comment);
	}

	/**
	 * Returns the comments to this post
	 *
	 * @return \Doctrine\Common\Collections\Collection<\TYPO3\Blog\Domain\Model\Comment>
	 */
	public function getComments() {
		return $this->comments;
	}

	/**
	 * Returns the number of comments
	 *
	 * @return integer The number of comments
	 */
	public function getNumberOfComments() {
		return count($this->comments);
	}

	/**
	 * Sets the posts related to this post
	 *
	 * @param \Doctrine\Common\Collections\Collection<\TYPO3\Blog\Domain\Model\Post> $relatedPosts The related posts
	 * @return void
	 */
	public function setRelatedPosts(\Doctrine\Common\Collections\Collection $relatedPosts) {
		$this->relatedPosts = clone $relatedPosts;
	}

	/**
	 * Returns the posts related to this post
	 *
	 * @return \Doctrine\Common\Collections\Collection<\TYPO3\Blog\Domain\Model\Post> The related posts
	 */
	public function getRelatedPosts() {
		return clone $this->relatedPosts;
	}

	/**
	 * Getter for category
	 *
	 * @return TYPO3\Blog\Domain\Model\Category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Setter for category
	 *
	 * @param TYPO3\Blog\Domain\Model\Category $category
	 */
	public function setCategory(\TYPO3\Blog\Domain\Model\Category $category) {
		$this->category = $category;
	}

}

?>