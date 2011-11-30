<?php
namespace TYPO3\FLOW3\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Blog Migration
 */
class Version20110613225637 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("CREATE TABLE blog_tag (flow3_persistence_identifier VARCHAR(40) NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(flow3_persistence_identifier)) ENGINE = InnoDB");
		$this->addSql("CREATE TABLE blog_blog (flow3_persistence_identifier VARCHAR(40) NOT NULL, flow3_resource_resource VARCHAR(40) DEFAULT NULL, title VARCHAR(80) NOT NULL, description VARCHAR(150) NOT NULL, blurb TEXT NOT NULL, twitterusername VARCHAR(80) NOT NULL, INDEX IDX_20C5DDD311FFD19F (flow3_resource_resource), PRIMARY KEY(flow3_persistence_identifier)) ENGINE = InnoDB");
		$this->addSql("CREATE TABLE blog_category (flow3_persistence_identifier VARCHAR(40) NOT NULL, name VARCHAR(80) NOT NULL, PRIMARY KEY(flow3_persistence_identifier)) ENGINE = InnoDB");
		$this->addSql("CREATE TABLE blog_comment (flow3_persistence_identifier VARCHAR(40) NOT NULL, blog_post VARCHAR(40) DEFAULT NULL, date DATETIME DEFAULT NULL, author VARCHAR(80) NOT NULL, emailaddress VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_7882EFEFBA5AE01D (blog_post), PRIMARY KEY(flow3_persistence_identifier)) ENGINE = InnoDB");
		$this->addSql("CREATE TABLE blog_image (flow3_persistence_identifier VARCHAR(40) NOT NULL, flow3_resource_resource VARCHAR(40) DEFAULT NULL, title VARCHAR(100) NOT NULL, INDEX IDX_35D2479711FFD19F (flow3_resource_resource), PRIMARY KEY(flow3_persistence_identifier)) ENGINE = InnoDB");
		$this->addSql("CREATE TABLE blog_post (flow3_persistence_identifier VARCHAR(40) NOT NULL, blog_blog VARCHAR(40) DEFAULT NULL, blog_image VARCHAR(40) DEFAULT NULL, blog_category VARCHAR(40) DEFAULT NULL, title VARCHAR(100) NOT NULL, linktitle VARCHAR(100) NOT NULL, date DATETIME DEFAULT NULL, author VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_BA5AE01D20C5DDD3 (blog_blog), INDEX IDX_BA5AE01D35D24797 (blog_image), INDEX IDX_BA5AE01D72113DE6 (blog_category), PRIMARY KEY(flow3_persistence_identifier)) ENGINE = InnoDB");
		$this->addSql("CREATE TABLE blog_post_tags_join (blog_post VARCHAR(40) NOT NULL, blog_tag VARCHAR(40) NOT NULL, INDEX IDX_C2DFA1C9BA5AE01D (blog_post), INDEX IDX_C2DFA1C96EC3989 (blog_tag), PRIMARY KEY(blog_post, blog_tag)) ENGINE = InnoDB");
		$this->addSql("CREATE TABLE blog_post_relatedposts_join (blog_post VARCHAR(40) NOT NULL, related_id VARCHAR(40) NOT NULL, INDEX IDX_766DFBA9BA5AE01D (blog_post), INDEX IDX_766DFBA94162C001 (related_id), PRIMARY KEY(blog_post, related_id)) ENGINE = InnoDB");
		$this->addSql("ALTER TABLE blog_blog ADD FOREIGN KEY (flow3_resource_resource) REFERENCES flow3_resource_resource(flow3_persistence_identifier)");
		$this->addSql("ALTER TABLE blog_comment ADD FOREIGN KEY (blog_post) REFERENCES blog_post(flow3_persistence_identifier)");
		$this->addSql("ALTER TABLE blog_image ADD FOREIGN KEY (flow3_resource_resource) REFERENCES flow3_resource_resource(flow3_persistence_identifier)");
		$this->addSql("ALTER TABLE blog_post ADD FOREIGN KEY (blog_blog) REFERENCES blog_blog(flow3_persistence_identifier)");
		$this->addSql("ALTER TABLE blog_post ADD FOREIGN KEY (blog_image) REFERENCES blog_image(flow3_persistence_identifier)");
		$this->addSql("ALTER TABLE blog_post ADD FOREIGN KEY (blog_category) REFERENCES blog_category(flow3_persistence_identifier)");
		$this->addSql("ALTER TABLE blog_post_tags_join ADD FOREIGN KEY (blog_post) REFERENCES blog_post(flow3_persistence_identifier)");
		$this->addSql("ALTER TABLE blog_post_tags_join ADD FOREIGN KEY (blog_tag) REFERENCES blog_tag(flow3_persistence_identifier)");
		$this->addSql("ALTER TABLE blog_post_relatedposts_join ADD FOREIGN KEY (blog_post) REFERENCES blog_post(flow3_persistence_identifier)");
		$this->addSql("ALTER TABLE blog_post_relatedposts_join ADD FOREIGN KEY (related_id) REFERENCES blog_post(flow3_persistence_identifier)");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("ALTER TABLE blog_post_tags_join DROP FOREIGN KEY ");
		$this->addSql("ALTER TABLE blog_blog DROP FOREIGN KEY ");
		$this->addSql("ALTER TABLE blog_image DROP FOREIGN KEY ");
		$this->addSql("ALTER TABLE blog_post DROP FOREIGN KEY ");
		$this->addSql("ALTER TABLE blog_post DROP FOREIGN KEY ");
		$this->addSql("ALTER TABLE blog_post DROP FOREIGN KEY ");
		$this->addSql("ALTER TABLE blog_comment DROP FOREIGN KEY ");
		$this->addSql("ALTER TABLE blog_post_tags_join DROP FOREIGN KEY ");
		$this->addSql("ALTER TABLE blog_post_relatedposts_join DROP FOREIGN KEY ");
		$this->addSql("ALTER TABLE blog_post_relatedposts_join DROP FOREIGN KEY ");
		$this->addSql("DROP TABLE blog_tag");
		$this->addSql("DROP TABLE blog_blog");
		$this->addSql("DROP TABLE blog_category");
		$this->addSql("DROP TABLE blog_comment");
		$this->addSql("DROP TABLE blog_image");
		$this->addSql("DROP TABLE blog_post");
		$this->addSql("DROP TABLE blog_post_tags_join");
		$this->addSql("DROP TABLE blog_post_relatedposts_join");
	}
}

?>