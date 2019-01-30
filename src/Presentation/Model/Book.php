<?php
/**
 * @author    Harry Osmar Sitohang <hsitohang@wayfair.com>
 * @copyright 2018 Wayfair LLC - All rights reserved
 */

namespace PhpBootstrap\Presentation\Model;

/**
 * @OA\Schema()
 */
class Book {
  /**
   * The book title
   *
   * @var string
   * @OA\Property(property="title", type="string")
   */
  private $title;

  /**
   * The price
   *
   * @var float
   * @OA\Property(property="price", type="number", format="float")
   */
  private $price;

  /**
   * The published year
   *
   * @var int
   * @OA\Property(property="published_year", type="integer")
   */
  private $year;

  /**
   * The evaluator
   * @var BookAuthor
   * @OA\Property(ref="#/components/schemas/BookAuthor")
   */
  private $author;

  public function __construct($authorName, $authorEmail, $title, $price, $year) {
    $this->author = new BookAuthor($authorName, $authorEmail);
    $this->title  = $title;
    $this->price  = $price;
    $this->year   = $year;
  }

  /**
   * @return mixed
   */
  public function getAuthorName() {
    return $this->author->getName();
  }

  /**
   * @return mixed
   */
  public function getAuthorEmail() {
    return $this->author->getEmail();
  }

  /**
   * @return mixed
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * @return mixed
   */
  public function getPrice() {
    return $this->price;
  }

  /**
   * @return mixed
   */
  public function getYear() {
    return $this->year;
  }
}