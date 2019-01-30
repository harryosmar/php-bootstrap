<?php
/**
 * @author    Harry Osmar Sitohang <hsitohang@wayfair.com>
 * @copyright 2018 Wayfair LLC - All rights reserved
 */

namespace PhpBootstrap\Presentation\Transfomer;

use League\Fractal\TransformerAbstract;

class EvaluatorResult extends TransformerAbstract {
  public function transform(\PhpBootstrap\Presentation\Model\EvaluatorResult $validationResult) {
    return [
        'status' => $validationResult->isStatus(),
        'failure_tags' => $validationResult->getFailureTags(),
    ];
  }
}