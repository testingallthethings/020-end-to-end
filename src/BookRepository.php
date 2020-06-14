<?php


namespace Braddle;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;

class BookRepository implements ISBNBookRepository
{

    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getByISBN(string $isbn) : Book
    {
        try {
            $repo = $this->entityManager->getRepository(Book::class);
            $book = $repo->findOneBy(["isbn" => $isbn]);
        } catch (DBALException $e) {
            throw new BookRepositoryException("Repository Broken", 0, $e);
        }

        if ($book instanceof Book) {
            return $book;
        }

        throw new BookNotFoundException("No book for ISBN: " . $isbn);
    }
}