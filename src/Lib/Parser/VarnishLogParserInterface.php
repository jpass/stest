<?php

namespace Lib\Parser;

interface VarnishLogParserInterface
{

    public function parse($line);

    public function hostFromLine($line);

    public function pathFromLine($line);
}
