<?php
/**
 * @author    Harry Osmar Sitohang <hsitohang@wayfair.com>
 * @copyright 2018 Wayfair LLC - All rights reserved
 */

namespace PhpBootstrap\Presentation\Model;

/**
 * @OA\Schema()
 */
class BookAuthor {
  /**
   * The author name
   *
   * @var string
   * @OA\Property()
   */
  private $name;

  /**
   * The author email
   *
   * @var string
   * @OA\Property()
   */
  private $email;

  public function __construct($authorName, $authorEmail) {
    $this->name  = $authorName;
    $this->email = $authorEmail;
  }

  /**
   * @return string
   */
  public function getName() : string {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getEmail() : string {
    return $this->email;
  }
}