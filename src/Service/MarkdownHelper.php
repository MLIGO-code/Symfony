<?php


namespace App\Service;


use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkdownHelper
{
    private $markdownParser;
    private $cache;
    private $isDebug;
    private $logger;

    function __construct(MarkdownParserInterface $markdownParser, CacheInterface $cache,
    bool $isDebug, LoggerInterface $mdLogger
    ){
        $this->cache=$cache;
        $this->markdownParser=$markdownParser;
        $this->isDebug=$isDebug;
        $this->logger = $mdLogger;
    }
    function parse(string $source):string
    {
        if(stripos($source,'cat')!==false){
            $this->logger->info("Gibbert");
        }


        if(!$this->isDebug)
            return $this->markdownParser->transformMarkdown($source);


        return $this->cache->get('markdown_'.md5($source),function () use ($source){
            return $this->markdownParser->transformMarkdown($source);
        });
    }
}