<?php

namespace spec\Lib\Reader;

use Lib\Parser\VarnishLogParserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class VarnishLogReaderSpec extends ObjectBehavior
{
    /**
     * @var vfsStreamDirectory
     */
    private $workDir;

    public function let(VarnishLogParserInterface $parser)
    {
        $this->workDir = vfsStream::setup('workDir');

        $data = '85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg2.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg3.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg4.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg5.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"';

        $this->createFile('test', $data);

        $data = '85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg2.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg2.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg2.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg2.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg2.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg2.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg2.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg3.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg3.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg3.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg4.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg4.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg4.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg4.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg5.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg5.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg5.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg5.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg5.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"
85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg6.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"';

        $this->createFile('test2', $data);

        $this->beConstructedWith($parser);
    }

    private function createFile($path, $content)
    {
        $file = vfsStream::newFile($path);
        $file->setContent($content);

        $this->workDir->addChild($file);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Lib\Reader\VarnishLogReader');
    }

    public function it_returns_top_five_hosts(VarnishLogParserInterface $parser)
    {
        $parser
            ->hostFromLine('85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"')
            ->willReturn('www.vg.no');

        $parser
            ->hostFromLine('85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg2.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"')
            ->willReturn('www.vg2.no');

        $parser
            ->hostFromLine('85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg3.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"')
            ->willReturn('www.vg3.no');

        $parser
            ->hostFromLine('85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg4.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"')
            ->willReturn('www.vg4.no');

        $parser
            ->hostFromLine('85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg5.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"')
            ->willReturn('www.vg5.no');

        $parser
            ->hostFromLine('85.164.152.30 - - [23/May/2012:14:01:05 +0200] "GET http://www.vg6.no/video/img/94949_160px.jpg HTTP/1.1" 200 3889 "http://www.vgtv.no/" "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"')
            ->willReturn('www.vg6.no');

        $this->read('vfs://workDir/test')->getTopHosts(5)->shouldReturn(
            array(
                'www.vg5.no' => 1,
                'www.vg4.no' => 1,
                'www.vg3.no' => 1,
                'www.vg2.no' => 1,
                'www.vg.no' => 1,
            )
        );

        $this->read('vfs://workDir/test2')->getTopHosts(5)->shouldReturn(
            array(
                'www.vg2.no' => 7,
                'www.vg5.no' => 5,
                'www.vg4.no' => 4,
                'www.vg3.no' => 3,
                'www.vg.no' => 2,
            )
        );
    }
}
