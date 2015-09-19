<?php

class Xml extends AppModel
{
    public function getMylist($mylistId)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_URL, "http://www.nicovideo.jp/mylist/".$mylistId."?rss=atom#+sort=6" );
        $strXml = curl_exec($ch);
        $xml = simplexml_load_string($strXml, 'SimpleXMLElement', LIBXML_NOCDATA);

        return $xml;
    }

    public function getRanking($t, $c)
    {
        $types = array('', 'hourly', 'daily', 'weekly', 'monthly', 'total');
        $categorys = array(
            'all',        // 0 + $B%+%F%4%j9g;;(B($BL$;HMQ(B)
            'g_ent2',     // 1 + $B%(%s%?%a!&2;3Z(B
            'ent',        // 2 $B%(%s%?!<%F%$%a%s%H(B
            'music',      // 3 $B2;3Z(B
            'sing',       // 4 $B2N$C$F$_$?(B
            'play',       // 5 $B1iAU$7$F$_$?(B
            'dance',      // 6 $BMY$C$F$_$?(B
            'vocaloid',   // 7 VOCALOID
            'nicoindies', // 8 $B%K%3%K%3%$%s%G%#!<%:(B
            'g_life2',    // 9 + $B@83h!&0lHL!&%9%](B
            'animal',     // 10 $BF0J*(B
            'cooking',    // 11 $BNAM}(B
            'nature',     // 12 $B<+A3(B
            'travel',     // 13 $BN99T(B
            'sport',      // 14 $B%9%]!<%D(B
            'lecture',    // 15 $B%K%3%K%3F02h9V:B(B
            'drive',      // 16 $B<V:\F02h(B
            'history',    // 17 $BNr;K(B
            'g_politics', // 18 + $B@/<#(B
            'g_tech',     // 19 + $B2J3X!&5;=Q(B
            'science',    // 20 $B2J3X(B
            'tech',       // 21 $B%K%3%K%35;=QIt(B
            'handcraft',  // 22 $B%K%3%K%3<j7]It(B
            'make',       // 23 $B:n$C$F$_$?(B
            'g_culture2', // 24 + $B%"%K%a!&%2!<%`!&3((B
            'anime',      // 25 $B%"%K%a(B
            'game',       // 26 $B%2!<%`(B
            'toho',       // 27 $BElJ}(B
            'imas',       // 28 $B%"%$%I%k%^%9%?!<(B
            'radio',      // 29 $B%i%8%*(B
            'draw',       // 30 $BIA$$$F$_$?(B
            'g_other',    // 31 + $B$=$NB>(B
            'are',        // 32 $BNc$N%"%l(B
            'diary',      // 33 $BF|5-(B
            'other',      // 34 $B$=$NB>(B
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_URL, "http://www.nicovideo.jp/ranking/fav/".$types[$t]."/".$categorys[$c]."?rss=atom" );
        $strXml = curl_exec($ch);
        $xml = simplexml_load_string($strXml, 'SimpleXMLElement', LIBXML_NOCDATA);

        return $xml;
    }

}

