<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201207145846 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE9781421C');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEB16566A');
        $this->addSql('DROP INDEX IDX_E00CEDDEB16566A ON booking');
        $this->addSql('DROP INDEX UNIQ_E00CEDDE9781421C ON booking');
        $this->addSql('ALTER TABLE booking ADD lift_id INT NOT NULL, ADD student_id INT NOT NULL, ADD booking_seats_booked INT NOT NULL, DROP booking_lift_id_id, DROP booking_stagiaire_id_id, DROP booking_id, DROP booking_seats_book');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE95AE0E79 FOREIGN KEY (lift_id) REFERENCES lift (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDECB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE95AE0E79 ON booking (lift_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDECB944F1A ON booking (student_id)');
        $this->addSql('ALTER TABLE lift ADD student_id INT NOT NULL, DROP lift_id');
        $this->addSql('ALTER TABLE lift ADD CONSTRAINT FK_737D1E0CCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('CREATE INDEX IDX_737D1E0CCB944F1A ON lift (student_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE95AE0E79');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDECB944F1A');
        $this->addSql('DROP INDEX IDX_E00CEDDE95AE0E79 ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDECB944F1A ON booking');
        $this->addSql('ALTER TABLE booking ADD booking_lift_id_id INT NOT NULL, ADD booking_stagiaire_id_id INT NOT NULL, ADD booking_id INT NOT NULL, ADD booking_seats_book INT NOT NULL, DROP lift_id, DROP student_id, DROP booking_seats_booked');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE9781421C FOREIGN KEY (booking_stagiaire_id_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEB16566A FOREIGN KEY (booking_lift_id_id) REFERENCES student (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEB16566A ON booking (booking_lift_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDE9781421C ON booking (booking_stagiaire_id_id)');
        $this->addSql('ALTER TABLE lift DROP FOREIGN KEY FK_737D1E0CCB944F1A');
        $this->addSql('DROP INDEX IDX_737D1E0CCB944F1A ON lift');
        $this->addSql('ALTER TABLE lift ADD lift_id INT DEFAULT NULL, DROP student_id');
    }
}
