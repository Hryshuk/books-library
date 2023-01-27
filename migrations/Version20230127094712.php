<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230127094712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // login: admin
        // password: admin
        $this->addSql("INSERT INTO `sonata_user__user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'admin', 'admin@gmail.com', 'admin@gmail.com', 1, NULL, '\$argon2id\$v=19\$m=65536,t=4,p=1\$w1HjKHqFsWCBbTG5pJ8UPQ\$iy2dh54kB9tHxGPyYbnTF0mbdk63HFLoUlcCkQCHw1o', '2023-01-27 11:52:16', NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', '2023-01-27 11:51:21', '2023-01-27 11:52:16');
");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE `sonata_user__user`;');
    }
}
