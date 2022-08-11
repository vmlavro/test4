<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;

class MatrixConverter
{
    public function fromXml(string $xmlString): array
    {
        $response = [];
        $crawler = new Crawler($xmlString);

        $crawler->filter('catalog > item')->each(function (Crawler $tr, $i) use (&$response) {
            $itemRow = [];
            foreach ($tr->children() as $child) {
                $itemRow[$child->nodeName] = $child->nodeValue;
            }

            $response[] = $itemRow;
        });

        return $response;
    }
}
