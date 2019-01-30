<?php
/**
 * @author    Harry Osmar Sitohang <hsitohang@wayfair.com>
 * @copyright 2018 Wayfair LLC - All rights reserved
 */

namespace PhpBootstrap\Presentation\Model;

/**
 * @OA\Schema()
 */
class Books implements \IteratorAggregate {
  /**
   * List of Book
   *
   * @var Book[]|array
   * @OA\Property(
   *   property="data",
   *   @OA\Items(ref="#/components/schemas/Book")
   * )
   */
  private $list;

  /**
   * Books constructor.
   *
   * @param array $list
   */
  public function __construct(array $list) {
    $this->list = $list;
  }

  /**
   * Retrieve an external iterator
   *
   * @link  https://php.net/manual/en/iteratoraggregate.getiterator.php
   * @return Book[]
   * <b>Traversable</b>
   * @since 5.0.0
   */
  public function getIterator() {
    return new \ArrayIterator($this->list);
  }
}