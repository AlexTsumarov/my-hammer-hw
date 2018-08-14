<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180813143200 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cat_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_request (id INT AUTO_INCREMENT NOT NULL, zip_id INT NOT NULL, category_id INT NOT NULL, title VARCHAR(200) NOT NULL, end_dt DATETIME NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_A17838047D662686 (zip_id), INDEX IDX_A178380412469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, zip INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job_request ADD CONSTRAINT FK_A17838047D662686 FOREIGN KEY (zip_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE job_request ADD CONSTRAINT FK_A178380412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE job_request DROP FOREIGN KEY FK_A178380412469DE2');
        $this->addSql('ALTER TABLE job_request DROP FOREIGN KEY FK_A17838047D662686');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE job_request');
        $this->addSql('DROP TABLE location');
    }
}
