<?php


namespace Braddle;

use Doctrine\ORM\EntityManager;

class BookRepository
{

    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getByISBN(string $isbn) : Book
    {
        $repo = $this->entityManager->getRepository(Book::class);

        return $repo->findOneBy(["isbn" => $isbn]);
    }
}