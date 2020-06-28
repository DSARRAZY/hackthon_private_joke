<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625121050 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor_patient DROP FOREIGN KEY FK_8977B44687F4FB17');
        $this->addSql('CREATE TABLE drug_prescription (drug_id INT NOT NULL, prescription_id INT NOT NULL, INDEX IDX_79FCA3AAABCA765 (drug_id), INDEX IDX_79FCA3A93DB413D (prescription_id), PRIMARY KEY(drug_id, prescription_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prescription (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, dosage INT NOT NULL, duration INT NOT NULL, beginning_of_treatment DATE NOT NULL, INDEX IDX_1FBFB8D96B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE drug_prescription ADD CONSTRAINT FK_79FCA3AAABCA765 FOREIGN KEY (drug_id) REFERENCES drug (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE drug_prescription ADD CONSTRAINT FK_79FCA3A93DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D96B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE doctor_patient');
        $this->addSql('DROP TABLE patient_drug');
        $this->addSql('ALTER TABLE drug ADD description LONGTEXT NOT NULL, DROP dosage, DROP morning, DROP noon, DROP duration, DROP date, DROP evening');
        $this->addSql('ALTER TABLE patient ADD name VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, DROP firstname, DROP lastname, CHANGE phone phone INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE drug_prescription DROP FOREIGN KEY FK_79FCA3A93DB413D');
        $this->addSql('CREATE TABLE doctor (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lastname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, specialty VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, phone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE doctor_patient (doctor_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_8977B4466B899279 (patient_id), INDEX IDX_8977B44687F4FB17 (doctor_id), PRIMARY KEY(doctor_id, patient_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE patient_drug (patient_id INT NOT NULL, drug_id INT NOT NULL, INDEX IDX_CA7A37F6AABCA765 (drug_id), INDEX IDX_CA7A37F66B899279 (patient_id), PRIMARY KEY(patient_id, drug_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE doctor_patient ADD CONSTRAINT FK_8977B4466B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE doctor_patient ADD CONSTRAINT FK_8977B44687F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_drug ADD CONSTRAINT FK_CA7A37F66B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_drug ADD CONSTRAINT FK_CA7A37F6AABCA765 FOREIGN KEY (drug_id) REFERENCES drug (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE drug_prescription');
        $this->addSql('DROP TABLE prescription');
        $this->addSql('ALTER TABLE drug ADD dosage VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD morning TINYINT(1) NOT NULL, ADD noon TINYINT(1) NOT NULL, ADD duration INT NOT NULL, ADD date DATE NOT NULL, ADD evening TINYINT(1) NOT NULL, DROP description');
        $this->addSql('ALTER TABLE patient ADD firstname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD lastname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP name, DROP email, CHANGE phone phone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
