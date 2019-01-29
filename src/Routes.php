<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 4:21 PM
 */

namespace PhpBootstrap;

use League\Container\Container;
use League\Route\RouteGroup;
use PhpBootstrap\Controller\HelloWorld;
use PhpBootstrap\Middleware\DummyTokenChecker;
use PhpBootstrap\Contracts\Response;
use PhpBootstrap\Middleware\Response\applicationJSON;
use PhpBootstrap\Middleware\Response\textHTML;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\RouteCollection;
use WF\Shared\Merchandising\Centralized_Validation_Service\Data_Interface\Empty_Additional_Data;
use WF\Shared\Merchandising\Centralized_Validation_Service\Data_Interface\Input_Data_Context;
use WF\Shared\Merchandising\Centralized_Validation_Service\Data_Interface\Map_Data_Record;
use WF\Shared\Merchandising\Centralized_Validation_Service\Evaluators\Conjunction;
use WF\Shared\Merchandising\Centralized_Validation_Service\Evaluators\Data_Lookup;
use WF\Shared\Merchandising\Centralized_Validation_Service\Evaluators\Disjunction;
use WF\Shared\Merchandising\Centralized_Validation_Service\Evaluators\Equals;
use WF\Shared\Merchandising\Centralized_Validation_Service\Evaluators\Is_Digit;
use WF\Shared\Merchandising\Centralized_Validation_Service\Evaluators\Literal;
use WF\Shared\Merchandising\Centralized_Validation_Service\Evaluators\Modulo;
use WF\Shared\Merchandising\Centralized_Validation_Service\Evaluators\Text_Is_Not_Blank;

class Routes {
  final public static function collections(
      RouteCollection $route,
      Container $container
  ) {
    /**
     * Content-Type: application/json
     */
    $route->group(
        '', function (RouteGroup $route) use ($container) {
      $route->map(
          'GET',
          '/',
          function (ServerRequestInterface $request, Response $response) {
            return $response->errorNotFound();
          }
      );

      $route->map(
          'POST',
          '/validation',
          function (ServerRequestInterface $request, Response $response) {
            $params        = $request->getParsedBody();
            $evaluatorTree = new Conjunction(
                [
                    new Text_Is_Not_Blank(new Data_Lookup('lead_time'), 'TEXT_IS_NOT_BLANK'),
                    new Is_Digit(new Data_Lookup('lead_time'), 'IS_DIGIT'),
                    new Disjunction(
                        [
                            new Equals(new Data_Lookup('lead_time'), new Literal("16")),
                            new Equals(
                                new Literal(0),
                                new Modulo(
                                    new Data_Lookup('lead_time'),
                                    new Literal("24")
                                )
                            )
                        ],
                        'INVALID_LEAD_TIME'
                    )
                ]
            );

            $dataRecord       = new Map_Data_Record($params);
            $additionalData   = new Empty_Additional_Data();
            $inputDataContext = new Input_Data_Context($dataRecord, $additionalData);
            $evaluatorResult  = $evaluatorTree->evaluate($inputDataContext);

            return $response->withArray(
                [
                    'status' => $evaluatorResult->getResult(),
                    'failure_tags' => $evaluatorResult->getViolatedEvaluatorsFailureTags()->getFailureTags()
                ]
            );
          }
      );

    }
    )->middleware(new applicationJSON());
  }
}