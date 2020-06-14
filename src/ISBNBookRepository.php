<?php

namespace Braddle;

interface ISBNBookRepository
{
    public function getByISBN(string $isbn) : Book;
}