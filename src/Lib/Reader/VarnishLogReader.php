<?php

namespace Lib\Reader;

use Lib\Parser\VarnishLogParserInterface;

class VarnishLogReader
{
    /**
     * @var VarnishLogParserInterface
     */
    private $parser;

    private $data;

    public function __construct(VarnishLogParserInterface $parser)
    {
        $this->parser = $parser;
    }

    public function read($file)
    {
        $this->data = array();

        $handle = fopen($file, "r");
        while (($line = fgets($handle)) !== false) {
            $this->data[] = trim($line);
        }

        fclose($handle);

        return $this;
    }

    public function getTopHosts($top = false)
    {
        $tmp = array();
        foreach($this->data as $item)
        {
            $host = $this->parser->hostFromLine($item);
            if(isset($tmp[$host]))
            {
                $tmp[$host] += 1;
            }
            else
            {
                $tmp[$host] = 1;
            }
        }

        arsort($tmp);

        if($top)
        {
            return array_slice($tmp, 0, $top);
        }

        return $tmp;
    }
}
