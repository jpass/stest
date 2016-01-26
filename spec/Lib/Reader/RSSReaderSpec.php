<?php

namespace spec\Lib\Reader;

use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RSSReaderSpec extends ObjectBehavior
{
    /**
     * @var vfsStreamDirectory
     */
    private $workDir;

    public function it_is_initializable()
    {
        $this->workDir = vfsStream::setup('workDir');

        $this->createFile('test', trim('
        <?xml version="1.0" encoding="UTF-8"?>
        <rss version="2.0" xmlns:vg="http://www.vg.no/namespace">
            <channel>
                <image>
                    <title>VG RSS</title>
                    <url>http://1.vgc.no/gfx/vg-rss.png</url>
                    <link>http://www.vg.no</link>
                </image>
                <title>VG RSS</title>
                <ttl>10</ttl>
                <description>VG RSS</description>
                <link>http://www.vg.no/rss/feed/forsiden/?frontId=1</link>
                <lastBuildDate>Tue, 26 Jan 2016 03:17:00 +0100</lastBuildDate>
                <item>
                    <title>Europol: Dette er IS\' nye terror-strategi</title>
                    <description></description>
                    <link>http://www.vg.no/nyheter/utenriks/is/europol-dette-er-is-nye-terror-strategi/a/23602925/</link>
                    <guid>http://www.vg.no/a/23602925/</guid>
                    <vg:waplink>http://www.vg.no/nyheter/utenriks/is/europol-dette-er-is-nye-terror-strategi/a/23602925/</vg:waplink>
                    <vg:img></vg:img>
                    <vg:articleImg></vg:articleImg>
                    <image></image>
                    <enclosure url="" length="0" type="img/jpg"></enclosure>
                    <vg:body></vg:body>
                    <pubDate>Tue, 26 Jan 2016 00:07:06 +0100</pubDate>
                </item>
            </channel>
        </rss>
        '));

        $this->createFile('test2', trim('
        <?xml version="1.0" encoding="UTF-8"?>
        <rss version="2.0" xmlns:vg="http://www.vg.no/namespace">
            <channel>
                <image>
                    <title>VG RSS</title>
                    <url>http://1.vgc.no/gfx/vg-rss.png</url>
                    <link>http://www.vg.no</link>
                </image>
                <title>VG RSS</title>
                <ttl>10</ttl>
                <description>VG RSS</description>
                <link>http://www.vg.no/rss/feed/forsiden/?frontId=1</link>
                <lastBuildDate>Tue, 26 Jan 2016 03:17:00 +0100</lastBuildDate>
                <item>
                    <title>Europol: Dette er IS\' nye terror-strategi</title>
                    <description></description>
                    <link>http://www.vg.no/nyheter/utenriks/is/europol-dette-er-is-nye-terror-strategi/a/23602925/</link>
                    <guid>http://www.vg.no/a/23602925/</guid>
                    <vg:waplink>http://www.vg.no/nyheter/utenriks/is/europol-dette-er-is-nye-terror-strategi/a/23602925/</vg:waplink>
                    <vg:img></vg:img>
                    <vg:articleImg></vg:articleImg>
                    <image></image>
                    <enclosure url="" length="0" type="img/jpg"></enclosure>
                    <vg:body></vg:body>
                    <pubDate>Tue, 26 Jan 2016 00:07:06 +0100</pubDate>
                </item>
                <item>
                    <title>Slår fedme-alarm: «Fido» har blitt farlig fet</title>
                    <description></description>
                    <link>http://www.vg.no/forbruker/dyrene/veterinaerer-slaar-alarm-om-fedme-boelge-blant-norske-hunder/a/23602224/</link>
                    <guid>http://www.vg.no/a/23602224/</guid>
                    <vg:waplink>http://www.vg.no/forbruker/dyrene/veterinaerer-slaar-alarm-om-fedme-boelge-blant-norske-hunder/a/23602224/</vg:waplink>
                    <vg:img></vg:img>
                    <vg:articleImg></vg:articleImg>
                    <image></image>
                    <enclosure url="" length="0" type="img/jpg"></enclosure>
                    <vg:body></vg:body>
                    <pubDate>Tue, 26 Jan 2016 01:45:22 +0100</pubDate>
                </item>
                <item>
                    <title>Foreldre om ungdomspsykiatrien: Blir holdt utenfor i behandlingen</title>
                    <description></description>
                    <link>http://pluss.vg.no/2016/01/26/2289/2289_23596225</link>
                    <guid>http://pluss.vg.no/2016/01/26/2289/2289_23596225</guid>
                    <vg:waplink>http://pluss.vg.no/2016/01/26/2289/2289_23596225</vg:waplink>
                    <vg:img></vg:img>
                    <vg:articleImg></vg:articleImg>
                    <image></image>
                    <enclosure url="" length="0" type="img/jpg"></enclosure>
                    <vg:body></vg:body>
                    <pubDate>Tue, 26 Jan 2016 01:28:14 +0100</pubDate>
                </item>
            </channel>
        </rss>
        '));

        $this->shouldHaveType('Lib\Reader\RSSReader');
    }

    private function createFile($path, $content)
    {
        $file = vfsStream::newFile($path);
        $file->setContent($content);

        $this->workDir->addChild($file);
    }

    public function it_reads_feed_from_url()
    {
        $this->read('vfs://workDir/test')->shouldReturn(array(
            array(
                'title' => "Europol: Dette er IS' nye terror-strategi",
                'link' => 'http://www.vg.no/nyheter/utenriks/is/europol-dette-er-is-nye-terror-strategi/a/23602925/',
                'date' => 'Tue, 26 Jan 2016 00:07:06 +0100'
            )
        ));
    }

    public function it_returns_articles_sorted_by_publication_date_newest_first()
    {
        $this->read('vfs://workDir/test2')->shouldReturn(array(
            array(
                'title' => "Slår fedme-alarm: «Fido» har blitt farlig fet",
                'link' => 'http://www.vg.no/forbruker/dyrene/veterinaerer-slaar-alarm-om-fedme-boelge-blant-norske-hunder/a/23602224/',
                'date' => 'Tue, 26 Jan 2016 01:45:22 +0100'
            ),
            array(
                'title' => "Foreldre om ungdomspsykiatrien: Blir holdt utenfor i behandlingen",
                'link' => 'http://pluss.vg.no/2016/01/26/2289/2289_23596225',
                'date' => 'Tue, 26 Jan 2016 01:28:14 +0100'
            ),
            array(
                'title' => "Europol: Dette er IS' nye terror-strategi",
                'link' => 'http://www.vg.no/nyheter/utenriks/is/europol-dette-er-is-nye-terror-strategi/a/23602925/',
                'date' => 'Tue, 26 Jan 2016 00:07:06 +0100'
            )
        ));
    }
}
