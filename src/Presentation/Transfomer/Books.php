<?php
/**
 * @author    Harry Osmar Sitohang <hsitohang@wayfair.com>
 * @copyright 2018 Wayfair LLC - All rights reserved
 */

namespace PhpBootstrap\Presentation\Transfomer;

use League\Fractal\TransformerAbstract;
use PhpBootstrap\Presentation\Model\Book;

class Books extends TransformerAbstract {
  public function transform(Book $book) {
    return [
        'title' => $book->getTitle(),
        'author' => [
            'name' => $book->getAuthorName(),
            'email' => $book->getAuthorEmail(),
        ],
        'price' => $book->getPrice(),
        'published_year' => $book->getYear(),
    ];
  }
}