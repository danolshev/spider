<?php
namespace spiders;

use discoverers\MyXPathExpressionDiscoverer;
/**
* 
*/
class RpSpider extends MySpider
{
    protected function getXPathExpressionDiscoverer()
    {
        return new MyXPathExpressionDiscoverer('//div[@class="catalog_left_column"]//ul//li//a|div[@class="modern-page-navigation"]//a');
    }

    protected function setRequestHandler($spider)
    {

    }

    protected function getLinksByFilterXpath($resourse)
    {
        $links = $resource->getCrawler()->filterXpath('//table[@class="sale-table"]//td//a[not(@class="shop_links")]');
        $result = [];
        foreach ($links as $link) {
            $result[] = str_replace(['//', '/shop/shop/'], ['/', '/shop/'], $resource->getUri()->getHost() . $resource->getUri()->getPath() . $link->getAttribute("href"));
        }

        return $result;
    }
}