<?php

namespace Lib\Parser;

class VarnishLogParser implements VarnishLogParserInterface
{
    public function parse($line)
    {
        $regExp = '/((?:[0-9]{1,3}\.){3}[0-9]{1,3}) (.) (.) \[(.*?)\] "(.*?)" (\d+) (\d+) "(.*?)" "(.*?)"/';
        $matches = array();

        preg_match($regExp, $line, $matches);

        return $matches;
    }

    public function hostFromLine($line)
    {
        $url = $this->getUrl($line);

        $host = parse_url($url, PHP_URL_HOST);

        return $host;
    }

    public function getUrl($line)
    {
        $data = $this->parse($line);

        $query = $data[5];

        $matches = array();

        preg_match('/[a-z]+\s(.*?)\sHTTP\/\d\.\d/i', $query, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    public function pathFromLine($line)
    {
        $url = $this->getUrl($line);

        $host = parse_url($url, PHP_URL_PATH);

        return $host;
    }
}
