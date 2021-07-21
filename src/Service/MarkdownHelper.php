<?php


namespace App\Service;


use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkdownHelper
{
    private $markdownParser;
    private $cache;
    function __construct(MarkdownParserInterface $markdownParser, CacheInterface $cache){
        $this->cache=$cache;
        $this->markdownParser=$markdownParser;
    }
    function parse(string $source):string
    {
        return $this->cache->get('markdown_'.md5($source),function () use ($source){
            return $this->markdownParser->transformMarkdown($source);
        });
    }
}