<?php

namespace Lib\Reader;

use Lib\Parser\VarnishLogParserInterface;
use Symfony\Component\Security\Acl\Exception\Exception;

class VarnishLogReader
{
    /**
     * @var VarnishLogParserInterface
     */
    private $parser;

    private $file;

    public function __construct(VarnishLogParserInterface $parser)
    {
        $this->parser = $parser;
    }

    private function readLines($callback)
    {
        if(!is_callable($callback))
        {
            throw new Exception('Provided callback is not callable.');
        }

        $handle = fopen($this->file, "r");

        if (!$handle) {
            throw new Exception('Could not open file.');
        }

        while (($line = fgets($handle)) !== false) {
            $callback(trim($line));
        }

        fclose($handle);
    }

    public function read($file)
    {
        if ( !file_exists($file) ) {
            throw new Exception('File not found.');
        }

        $this->file = $file;

        return $this;
    }

    public function getTopHosts($top = false)
    {
        $tmp = array();

        $this->readLines(function($line) use(&$tmp) {
            $host = $this->parser->hostFromLine(trim($line));
            if(isset($tmp[$host]))
            {
                $tmp[$host] += 1;
            }
            else
            {
                $tmp[$host] = 1;
            }
        });

        arsort($tmp);

        if($top)
        {
            return array_slice($tmp, 0, $top);
        }

        return $tmp;
    }

    public function getTopPaths($top = false)
    {
        $tmp = array();
        $this->readLines(function($line) use(&$tmp) {
            $host = $this->parser->pathFromLine($line);
            if(isset($tmp[$host]))
            {
                $tmp[$host] += 1;
            }
            else
            {
                $tmp[$host] = 1;
            }
        });

        arsort($tmp);

        if($top)
        {
            return array_slice($tmp, 0, $top);
        }

        return $tmp;
    }
}
