<?php

namespace Lib\Reader;

class RSSReader
{
    public function read($url)
    {
        $feed = simplexml_load_file($url);
        if (!$feed)
        {
            return array();
        }

        $parsed = array();

        foreach ($feed->channel->item as $item)
        {
            $parsed[] = array(
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'date' => (string) $item->pubDate
            );
        }


        // sort articles by date
        usort($parsed,function ($a,$b){
            $t1 = strtotime($a['date']);
            $t2 = strtotime($b['date']);
            if ($t1 == $t2) {
                return 0;
            }

            // newest first
            return ($t1 > $t2) ? -1 : 1;
        });

        return $parsed;
    }
}
