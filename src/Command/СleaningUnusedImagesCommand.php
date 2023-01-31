<?php

namespace App\Command;

use App\Repository\BookRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class СleaningUnusedImagesCommand extends Command
{
    private BookRepository $bookRepository;

    private string $targetDirectory;

// the name of the command (the part after "bin/console")
protected static $defaultName = 'app:cleaning-unused-images';

    public function __construct(BookRepository $bookRepository, $targetDirectory)
    {
        $this->bookRepository = $bookRepository;
        $this->targetDirectory = $targetDirectory;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Cleaning up unused images for book covers.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Cleaning up unused images for book covers....');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $files = array_diff(scandir($this->targetDirectory), array('..', '.'));

        foreach ($files as $file) {
            $book = $this->bookRepository->findOneBy(['book_cover' => $file]);
            if (!$book) {
                 $res = unlink($this->targetDirectory . '/' . $file);
                 if ($res) {
                     $output->writeln('File ' . $file . ' was successfully deleted.');
                 }
            }
        }

        return 0;
    }

}