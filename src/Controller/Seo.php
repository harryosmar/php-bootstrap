<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 4/25/18
 * Time: 11:45 AM
 */

namespace PhpBootstrap\Controller;

use League\Csv\AbstractCsv;
use League\Csv\Reader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Seo extends Base
{
    const TABLE_NAME = 'seo_labels';

    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var \FluentPDO $pdo */
        $pdo = $this->container->get('pdo');

        $data = $pdo->from(self::TABLE_NAME)->limit(10)->fetchAll();

        $csv = $this->getCsvData($this->getCsvDataPath('seo-week2.csv'));

        $sqlQuery = '';
        foreach ($csv as $record) {
            $sqlQuery .= $this->generateRecordUpdateQuery($record) . "\n";
        }

        $response->getBody()->write($sqlQuery);
        return $response;
    }

    /**
     * @param array $record
     * @return string
     */
    private function generateRecordUpdateQuery($record)
    {
        return sprintf(
            "UPDATE `%s` SET `page_title` = '%s', `page_h1` = '%s', `page_description` = '%s' WHERE `region_id` %s %s AND `subregion_id` %s %s AND `category_id` %s %s;",
            self::TABLE_NAME,
            $record['page_title'],
            $record['page_h1'],
            $record['page_description'],
            $this->getWhereSeparator($record['region_id']),
            $record['region_id'],
            $this->getWhereSeparator($record['subregion_id']),
            $record['subregion_id'],
            $this->getWhereSeparator($record['category_id']),
            $record['category_id']
        );
    }

    /**
     * @param string|null $value
     * @return string
     */
    private function getWhereSeparator($value)
    {
        return $value === 'NULL' ? 'IS' : '=';
    }

    /**
     * @param string $filename
     * @return string
     */
    private function getCsvDataPath($filename)
    {
        return sprintf(
            implode(
                DIRECTORY_SEPARATOR,
                ['%s', '..', '..', 'resources', $filename]
            ),
            dirname(__FILE__)
        );
    }

    /**
     * @param $filePath
     * @return AbstractCsv
     */
    private function getCsvData($filePath)
    {
        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }

        $csv = Reader::createFromString(file_get_contents($filePath));
        $csv->setDelimiter(',');
        $csv->setHeaderOffset(0); //set the CSV header offset

        return $csv;
    }
}