<?php

namespace spec\Lib\Parser;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VarnishLogParserSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Lib\Parser\VarnishLogParser');
    }

    public function it_parses_one_line()
    {
        $this->parse('85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vgtv.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"')
            ->shouldReturn(array(
                '85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vgtv.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"',
                '85.164.152.30',
                '-',
                '-',
                '23/May/2012:14:01:05 +0200',
                'GET http://www.vgtv.no/video/img/94949_160px.jpg HTTP/1.1',
                '200',
                '3889',
                'http://www.vgtv.no/',
                'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0'
            ))
        ;

        $this->parse('178.232.38.87 - - [23/May/2012:14:01:05 +0200] "GET http://static.vg.no/iphone/js/front-min.js?20120509-1 HTTP/1.1" 200 2013 "http://touch.vg.no/" "Mozilla/5.0 (Linux; U; Android 2.3.3; en-no; HTC Nexus One Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1"')
             ->shouldReturn(array(
                 '178.232.38.87 - - [23/May/2012:14:01:05 +0200] "GET http://static.vg.no/iphone/js/front-min.js?20120509-1 HTTP/1.1" 200 2013 "http://touch.vg.no/" "Mozilla/5.0 (Linux; U; Android 2.3.3; en-no; HTC Nexus One Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1"',
                 '178.232.38.87',
                 '-',
                 '-',
                 '23/May/2012:14:01:05 +0200',
                 'GET http://static.vg.no/iphone/js/front-min.js?20120509-1 HTTP/1.1',
                 '200',
                 '2013',
                 'http://touch.vg.no/',
                 'Mozilla/5.0 (Linux; U; Android 2.3.3; en-no; HTC Nexus One Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1'
             ))
        ;
    }

    public function it_gets_host_from_line()
    {
        $this->hostFromLine('178.232.38.87 - - [23/May/2012:14:01:05 +0200] "GET http://static.vg.no/iphone/js/front-min.js?20120509-1 HTTP/1.1" 200 2013 "http://touch.vg.no/" "Mozilla/5.0 (Linux; U; Android 2.3.3; en-no; HTC Nexus One Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1"')
             ->shouldReturn('static.vg.no')
        ;

        $this->hostFromLine('85.166.121.178 - - [23/May/2012:14:01:05 +0200] "GET http://3.vgc.no/drfront/images/2012/05/16/c=10,11,813,415;w=388;h=198;41625.jpg HTTP/1.1" 200 24041 "http://www.vg.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.46 Safari/536.5"')
             ->shouldReturn('3.vgc.no')
        ;
    }

    public function it_gets_url_from_line()
    {
        $this->getUrl('178.232.38.87 - - [23/May/2012:14:01:05 +0200] "GET http://static.vg.no/iphone/js/front-min.js?20120509-1 HTTP/1.1" 200 2013 "http://touch.vg.no/" "Mozilla/5.0 (Linux; U; Android 2.3.3; en-no; HTC Nexus One Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1"')
             ->shouldReturn('http://static.vg.no/iphone/js/front-min.js?20120509-1')
        ;

        $this->getUrl('193.213.32.121 - - [23/May/2012:14:01:05 +0200] "GET http://2.vgc.no/drfront/images/2012/05/21/c=10,10,813,499;w=388;h=238;42179.jpg HTTP/1.1" 304 0 "http://www.vg.no/" "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; GTB7.3; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.4506.2152)"')
             ->shouldReturn('http://2.vgc.no/drfront/images/2012/05/21/c=10,10,813,499;w=388;h=238;42179.jpg')
        ;
    }
}
