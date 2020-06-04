<?php
namespace Braddle;

interface ISBNBookRetriever
{
    public function retrieveBookByISBN(string $isbn);
}