<?php

namespace spiders;

use VDB\Spider\Discoverer\XPathExpressionDiscoverer;
use handlers\DealderEquipRequestHandler;
/**
* 
*/
class DealerEquipCenterSpider extends MySpider
{
    protected function getXPathExpressionDiscoverer()
    {
        return new XPathExpressionDiscoverer('//article//h4//a|//a[@aria-label="Next"]');
    }

    protected function setRequestHandler($spider)
    {
        return $spider->getDownloader()->setRequestHandler(new DealderEquipRequestHandler());
    }

    protected function getLinksByFilterXpath($resource)
    {
        $links = $resource->getCrawler()->filterXpath('//div[@class="product_title"]//a');
        $result = [];
        foreach ($links as $link) {
            $result[] = str_replace('//', '/', $resource->getUri()->getHost() . $link->getAttribute("href"));
        }
        return $result;
    }
}