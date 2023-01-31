<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RecalculateBooksNumberForAuthorsCommand extends Command
{
// the name of the command (the part after "bin/console")
protected static $defaultName = 'app:recalculate-books';

    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Recalculate books number for authors.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Recalculate books number for authors...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $conn = $this->objectManager->getConnection();
        $sql = '
            UPDATE author AS a
            SET
            `books_number` = (
                SELECT COUNT(ba.book_id)
                FROM book_author AS ba
                WHERE ba.author_id = a.id
            ),
            `is_updated` = 1
            WHERE 1
            ';
        $count = $conn->executeStatement($sql);

        if ($count) {
            $output->writeln('It was updated ' . $count . ' rows.');
            return 0;
        }

        $output->writeln("Error: can't update.");
        return 1;
    }


}