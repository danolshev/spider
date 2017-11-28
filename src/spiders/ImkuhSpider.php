<?php

namespace spiders;

use discoverers\MyXPathExpressionDiscoverer;
/**
* 
*/
class ImkuhSpider extends MySpider
{
    protected function getXPathExpressionDiscoverer()
    {
        return new MyXPathExpressionDiscoverer('//a[@class="mgroup"]|//a[@class="menu2"]|//div[@class="pagination-wrap"]//ul//li//a');
    }

    protected function setRequestHandler($spider)
    {

    }

    protected function getLinksByFilterXpath($resource)
    {
        $links = $resource->getCrawler()->filterXpath('//td//a[@style="text-transform: uppercase;"]');
        $result = [];
        foreach ($links as $link) {
            $result[] = $link->getAttribute("href");
        }

        return $result;
    }
}