<?php
namespace F3\FLOW3\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Migration adding "fullDescription", "keywords" and "googleAnalyticsAccountNumber" to the Blog model.
 */
class Version20110617103819 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("ALTER TABLE blog_blog ADD fulldescription VARCHAR(255) NOT NULL, ADD keywords VARCHAR(255) NOT NULL, ADD googleanalyticsaccountnumber VARCHAR(20) NOT NULL");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("ALTER TABLE blog_blog DROP fulldescription, DROP keywords, DROP googleanalyticsaccountnumber");
	}
}

?>