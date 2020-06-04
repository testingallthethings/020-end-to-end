<?php


namespace Braddle;


class BookManager implements ISBNBookRetriever
{
    private BookRepository $repo;

    public function __construct(BookRepository $repo)
    {
        $this->repo = $repo;
    }

    public function retrieveBookByISBN(string $isbn)
    {
        try {
            return $this->repo->getByISBN($isbn);
        } catch (BookRepositoryException $e) {
            throw new BookRetrievalException("Error getting your book", 0, $e);
        }
    }
}