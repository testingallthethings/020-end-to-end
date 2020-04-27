<?php
declare(strict_types=1);

namespace Braddle;

class Book implements \JsonSerializable
{
    private int $id;
    private string $isbn;
    private string $title;
    private string $author;
    private int $numberOfPages;

    public function __construct(string $isbn, string $title, string $author, int $numberOfPages)
    {
        $this->isbn = $isbn;
        $this->title = $title;
        $this->author = $author;
        $this->numberOfPages = $numberOfPages;
    }

    public function jsonSerialize()
    {
        return [
            "isbn" => $this->isbn,
            "title" => $this->title,
            "author" => $this->author,
            "number_of_pages" => $this->numberOfPages,
        ];
    }
}