<?php
namespace Braddle;

use PHPUnit\Framework\TestCase;

class BookManagerTest extends TestCase
{
    public function testHandlingRepositoryError()
    {
        $this->expectException(BookRetrievalException::class);

        $r = \Mockery::mock(BookRepository::class);
        $r->shouldReceive("getByISBN")
            ->andThrow(BookRepositoryException::class);

        $m = new BookManager($r);
        $m->retrieveBookByISBN("987654321");
    }


}
