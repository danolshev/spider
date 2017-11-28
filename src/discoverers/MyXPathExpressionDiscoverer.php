<?php

namespace discoverers;

use VDB\Spider\Discoverer\XPathExpressionDiscoverer;
use VDB\Spider\Resource;
use VDB\Spider\Uri\DiscoveredUri;
use VDB\Uri\Exception\UriSyntaxException;
use VDB\Uri\Uri;

class MyXPathExpressionDiscoverer extends XPathExpressionDiscoverer
{
    protected function getFilteredCrawler(Resource $resource)
    {
        return $resource->getCrawler()->filterXPath($this->selector);
    }

    public function discover(Resource $resource)
    {
        $crawler = $this->getFilteredCrawler($resource);

        $uris = array();
        foreach ($crawler as $node) {
            try {
                if ($node->nodeType == XML_ELEMENT_NODE) {
                    $uris[] = new DiscoveredUri(new Uri($node->getAttribute('href'), $resource->getUri()->toString()));
                }
            } catch (UriSyntaxException $e) {
                // do nothing. We simply ignore invalid URI's
            }
        }
        return $uris;
    }
}