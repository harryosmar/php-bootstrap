<?php
/**
 * @author    Harry Osmar Sitohang <hsitohang@wayfair.com>
 * @copyright 2018 Wayfair LLC - All rights reserved
 */

namespace PhpBootstrap\Presentation\Model;

use WF\Shared\Merchandising\Centralized_Validation_Service\Evaluator_Results\Evaluator_Result;

/**
 * @OA\Schema()
 */
class EvaluatorResult {
  /**
   * The status
   *
   * @var bool
   * @OA\Property()
   */
  private $status;

  /**
   * The failure tags
   *
   * @var array
   * @OA\Property(
   *   @OA\Items(type="string")
   * )
   */
  private $failureTags;

  /**
   * ValidationResult constructor.
   *
   * @param Evaluator_Result $evaluator_Result
   */
  public function __construct(Evaluator_Result $evaluator_Result) {
    $this->status      = (bool)$evaluator_Result->getResult();
    $this->failureTags = $evaluator_Result->getViolatedEvaluatorsFailureTags()->getFailureTags();
  }

  /**
   * @return bool
   */
  public function isStatus() : bool {
    return $this->status;
  }

  /**
   * @return array
   */
  public function getFailureTags() : array {
    return $this->failureTags;
  }
}