<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201204073906 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, booking_lift_id_id INT NOT NULL, booking_stagiaire_id_id INT NOT NULL, booking_id INT NOT NULL, booking_seats_book INT NOT NULL, INDEX IDX_E00CEDDEB16566A (booking_lift_id_id), UNIQUE INDEX UNIQ_E00CEDDE9781421C (booking_stagiaire_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lift (id INT AUTO_INCREMENT NOT NULL, lift_id INT DEFAULT NULL, lift_city_start VARCHAR(255) NOT NULL, lift_city_goal VARCHAR(255) NOT NULL, lift_date DATETIME NOT NULL, lift_seats INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, student_name VARCHAR(255) NOT NULL, student_last_name VARCHAR(255) NOT NULL, student_mail VARCHAR(255) NOT NULL, student_picture VARCHAR(255) DEFAULT NULL, student_phone INT NOT NULL, password VARCHAR(100) NOT NULL, student_description LONGTEXT DEFAULT NULL, student_start_date DATETIME NOT NULL, student_end_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEB16566A FOREIGN KEY (booking_lift_id_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE9781421C FOREIGN KEY (booking_stagiaire_id_id) REFERENCES student (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEB16566A');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE9781421C');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE lift');
        $this->addSql('DROP TABLE student');
    }
}
