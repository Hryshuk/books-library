<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125154109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO `author` (`id`, `first_name`, `last_name`, `books_number`) VALUES
(1, '1-author', '1-author', 1),
(2, '2-author', '2-author', 2),
(3, '3-author', '3-author', 1),
(4, '4-author', '4-author', 3),
(5, '5-author', '5-author', 1),
(6, '6-author', '6-author', 0),
(7, '7-author', '7-author', 3),
(8, '8-author', '8-author', 1);");

        $this->addSql("INSERT INTO `book` (`id`, `name`, `description`, `published`, `book_cover`) VALUES
(1, '1-book', 'description', '2023-01-01', NULL),
(2, '2-book', 'description', '2022-01-01', NULL),
(3, '3-book', 'description', '2023-01-01', NULL),
(4, '4-book', 'description', '2024-01-01', NULL),
(5, '5-book', 'description', '2021-01-01', NULL),
(6, '6-book', 'description', '2020-01-01', NULL),
(7, '7-book', 'description', '2019-01-01', NULL),
(8, '8-book', 'description', '2011-01-01', NULL),
(9, '9-book', 'description', '2012-01-01', NULL);");

        $this->addSql("INSERT INTO `book_author` (`book_id`, `author_id`) VALUES
(1, 1),
(1, 3),
(2, 4),
(2, 7),
(3, 4),
(3, 5),
(4, 2),
(5, 4),
(5, 7),
(6, 2),
(6, 8),
(7, 7);");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE `book_author`;');
        $this->addSql('TRUNCATE TABLE `author`;');
        $this->addSql('TRUNCATE TABLE `book`;');
    }
}
