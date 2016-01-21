<?php

namespace Lib\Parser;

interface VarnishLogParserInterface
{

    public function parse($argument1);

    public function hostFromLine($argument1);
}
