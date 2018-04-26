<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 4/25/18
 * Time: 11:45 AM
 */

namespace PhpBootstrap\Controller;

use FluentPDO;
use League\Csv\AbstractCsv;
use League\Csv\Reader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Seo extends Base
{
    const TABLE_NAME = 'seo_labels';

    const LANG = 'id';

    const NEWLINE = "\n";

    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        /** @var FluentPDO $pdo */
        $pdo = $this->container->get('pdo');

        $csv = $this->getCsvData($this->getCsvDataPath('seo-week1.csv'));

        $sqlQueryUpdate = '';
        $sqlQueryInsert = '';
        foreach ($csv as $record) {
            $this->generateRecordUpdateOrInsertQuery($pdo, $record, $sqlQueryUpdate, $sqlQueryInsert);
        }
        $sqlQueryInsert = $this->cleanSqlInsert($sqlQueryInsert);

        $response->getBody()->write($sqlQueryInsert . $sqlQueryUpdate);
        return $response;
    }

    /**
     * @param string $sqlQueryInsert
     * @return string
     */
    private function cleanSqlInsert($sqlQueryInsert)
    {
        $sqlQueryInsert = trim($sqlQueryInsert, "\n,");
        $sqlQueryInsert .= !empty($sqlQueryInsert) ? ';' : '';
        return $sqlQueryInsert;
    }

    /**
     * @param FluentPDO $pdo
     * @param array $newRecord
     * @param string $sqlQueryUpdate
     * @param string $sqlQueryInsert
     */
    private function generateRecordUpdateOrInsertQuery(FluentPDO $pdo, $newRecord, &$sqlQueryUpdate, &$sqlQueryInsert)
    {
        /** @var \SelectQuery $query */
        $query = $pdo->from(self::TABLE_NAME)
            ->where(
                sprintf('region_id %s ?', $this->getWhereSeparator($newRecord['region_id'])),
                $this->getValue($newRecord['region_id'])
            )->where(
                sprintf('subregion_id %s ?', $this->getWhereSeparator($newRecord['subregion_id'])),
                $this->getValue($newRecord['subregion_id'])
            )->where(
                sprintf('category_id %s ?', $this->getWhereSeparator($newRecord['category_id'])),
                $this->getValue($newRecord['category_id'])
            );

        $oldRecord = $query->fetchAll();

        /**
         * Insert Query
         */
        if (!$oldRecord) {
            $queryValues = sprintf(
                "('%s', %s, %s, %s, %s, %s, %s, %s, %s, %s, '%s', '%s', '%s', %s, %s, %s, %s, %s),%s",
                self::LANG,
                $newRecord['region_id'],
                $newRecord['subregion_id'],
                $newRecord['category_id'],
                $newRecord['fake_category'],
                $newRecord['page'],
                $newRecord['offer_seek'],
                $newRecord['tag'],
                $newRecord['tag_value'],
                $newRecord['phrase'],
                $newRecord['page_title'],
                $newRecord['page_h1'],
                $newRecord['page_description'],
                $newRecord['page_name'],
                $newRecord['seo_text'],
                $newRecord['seo_tags'],
                $newRecord['seo_places'],
                $newRecord['page_keywords'],
                self::NEWLINE
            );

            if (empty($sqlQueryInsert)) {
                $sqlQueryInsert .= sprintf("INSERT INTO `seo_labels` (`lang`, `region_id`, `subregion_id`, `category_id`, `fake_category`, `page`, `offer_seek`, `tag`, `tag_value`, `phrase`, `page_title`, `page_h1`, `page_description`, `page_name`, `seo_text`, `seo_tags`, `seo_places`, `page_keywords`)%s VALUES%s %s",
                    self::NEWLINE,
                    self::NEWLINE,
                    $queryValues
                );
            } else {
                $sqlQueryInsert .= sprintf(" %s", $queryValues);
            }
        }

        /**
         * Update Query
         */
        $sqlQueryUpdate .= sprintf(
            "UPDATE `%s` SET `page_title` = '%s', `page_h1` = '%s', `page_description` = '%s' WHERE `region_id` %s %s AND `subregion_id` %s %s AND `category_id` %s %s;",
            self::TABLE_NAME,
            $newRecord['page_title'],
            $newRecord['page_h1'],
            $newRecord['page_description'],
            $this->getWhereSeparator($newRecord['region_id']),
            $newRecord['region_id'],
            $this->getWhereSeparator($newRecord['subregion_id']),
            $newRecord['subregion_id'],
            $this->getWhereSeparator($newRecord['category_id']),
            $newRecord['category_id']
        ) . self::NEWLINE;
    }

    /**
     * @param string|null $value
     * @return string
     */
    private function getValue($value)
    {
        return $value === 'NULL' ? NULL : $value;
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