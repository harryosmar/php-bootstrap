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
use PhpBootstrap\Presentation\Model\Books;
use PhpBootstrap\Presentation\Model\Book;
use PhpBootstrap\Presentation\Model\EvaluatorResult;
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
    $route->group(
        '', function (RouteGroup $route) use ($container) {
      /**
       * @OA\Get(
       *     path="/",
       *     @OA\Response(response="404", description="Page not found")
       * )
       */
      $route->map(
          'GET',
          '/',
          function (ServerRequestInterface $request, Response $response) {
            return $response->errorNotFound();
          }
      );

      /**
       * @OA\Get(
       *     path="/books",
       *     @OA\Response(response="200", description="list of books", @OA\JsonContent(ref="#/components/schemas/Books"))
       * )
       */
      $route->map(
          'GET',
          '/books',
          function (ServerRequestInterface $request, Response $response) {
            return $response->withCollection(
                new Books(
                    [
                        new Book('harry', 'harryosmarsitohang', 'how to be a ninja', 100000, 2017),
                        new Book('harry', 'harryosmarsitohang', 'how to be a mage', 500000, 2016),
                        new Book('harry', 'harryosmarsitohang', 'how to be a samurai', 25000, 2000),
                    ]
                ),
                new \PhpBootstrap\Presentation\Transfomer\Books()
            );
          }
      );

      /**
       * @OA\Post(
       *     path="/validation",
       *     @OA\Response(response="200", description="Validation using evaluator", @OA\JsonContent(ref="#/components/schemas/EvaluatorResult"))
       * )
       */
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

            return $response->withItem(
                new EvaluatorResult($evaluatorResult),
                new \PhpBootstrap\Presentation\Transfomer\EvaluatorResult()
            );
          }
      );

    }
    )->middleware(new applicationJSON());
  }
}