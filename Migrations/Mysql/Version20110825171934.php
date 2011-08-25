<?php
namespace TYPO3\FLOW3\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Migration for table name changes (see #29213)
 */
class Version20110825171934 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("RENAME TABLE blog_blog TO typo3_blog_domain_model_blog");
		$this->addSql("RENAME TABLE blog_tag TO typo3_blog_domain_model_tag");
		$this->addSql("RENAME TABLE blog_category TO typo3_blog_domain_model_category");
		$this->addSql("RENAME TABLE blog_comment TO typo3_blog_domain_model_comment");
		$this->addSql("RENAME TABLE blog_image TO typo3_blog_domain_model_image");
		$this->addSql("RENAME TABLE blog_post TO typo3_blog_domain_model_post");
		$this->addSql("RENAME TABLE blog_post_tags_join TO typo3_blog_domain_model_post_tags_join");
		$this->addSql("RENAME TABLE blog_post_relatedposts_join TO typo3_blog_domain_model_post_relatedposts_join");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("RENAME TABLE typo3_blog_domain_model_blog TO blog_blog");
		$this->addSql("RENAME TABLE typo3_blog_domain_model_tag TO blog_tag");
		$this->addSql("RENAME TABLE typo3_blog_domain_model_category TO blog_category");
		$this->addSql("RENAME TABLE typo3_blog_domain_model_comment TO blog_comment");
		$this->addSql("RENAME TABLE typo3_blog_domain_model_image TO blog_image");
		$this->addSql("RENAME TABLE typo3_blog_domain_model_post TO blog_post");
		$this->addSql("RENAME TABLE typo3_blog_domain_model_post_tags_join TO blog_post_tags_join");
		$this->addSql("RENAME TABLE typo3_blog_domain_model_post_relatedposts_join TO blog_post_relatedposts_join");
	}
}

?>