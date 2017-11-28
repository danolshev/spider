<?php

namespace spiders;

use VDB\Spider\EventListener\PolitenessPolicyListener;
use VDB\Spider\Event\SpiderEvents;
use VDB\Spider\StatsHandler;
use VDB\Spider\Spider;
/**
* 
*/
class MySpider
{
    protected $spider;
    protected $maxQueueSize;
    protected $maxDepth;

    public function __construct($url, $maxQueueSize)
    {
        $this->spider = new Spider($url);
        $this->maxQueueSize = $maxQueueSize;
        $this->maxDepth = 10;
    }

    public function crawl()
    {
        $this->spider->getDiscovererSet()->set($this->getXPathExpressionDiscoverer());

        $this->spider->getDiscovererSet()->maxDepth = $this->maxDepth;
        $this->spider->getQueueManager()->maxQueueSize = $this->maxQueueSize;

        $politenessPolicyEventListener = new PolitenessPolicyListener(100);
        $this->spider->getDownloader()->getDispatcher()->addListener(
            SpiderEvents::SPIDER_CRAWL_PRE_REQUEST,
            array($politenessPolicyEventListener, 'onCrawlPreRequest')
        );
        $statsHandler = new StatsHandler();
        $this->spider->getQueueManager()->getDispatcher()->addSubscriber($statsHandler);
        $this->spider->getDispatcher()->addSubscriber($statsHandler);
        $this->setRequestHandler($this->spider);
        $this->spider->crawl();

        echo "\n  ENQUEUED:  " . count($statsHandler->getQueued());
        
        foreach ($this->spider->getDownloader()->getPersistenceHandler() as $resource) {
            $links = array_merge($links, $this->getLinksByFilterXpath($resourse));
        }
        return json_encode($links);
    }

    abstract protected function getXPathExpressionDiscoverer();

    abstract protected function setRequestHandler($spider);

    abstract protected function getLinksByFilterXpath($resourse);
}