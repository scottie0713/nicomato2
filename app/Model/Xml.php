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
            'all',        // 0 + カテゴリ合算(未使用)
            'g_ent2',     // 1 + エンタメ・音楽
            'ent',        // 2 エンターテイメント
            'music',      // 3 音楽
            'sing',       // 4 歌ってみた
            'play',       // 5 演奏してみた
            'dance',      // 6 踊ってみた
            'vocaloid',   // 7 VOCALOID
            'nicoindies', // 8 ニコニコインディーズ
            'g_life2',    // 9 + 生活・一般・スポ
            'animal',     // 10 動物
            'cooking',    // 11 料理
            'nature',     // 12 自然
            'travel',     // 13 旅行
            'sport',      // 14 スポーツ
            'lecture',    // 15 ニコニコ動画講座
            'drive',      // 16 車載動画
            'history',    // 17 歴史
            'g_politics', // 18 + 政治
            'g_tech',     // 19 + 科学・技術
            'science',    // 20 科学
            'tech',       // 21 ニコニコ技術部
            'handcraft',  // 22 ニコニコ手芸部
            'make',       // 23 作ってみた
            'g_culture2', // 24 + アニメ・ゲーム・絵
            'anime',      // 25 アニメ
            'game',       // 26 ゲーム
            'toho',       // 27 東方
            'imas',       // 28 アイドルマスター
            'radio',      // 29 ラジオ
            'draw',       // 30 描いてみた
            'g_other',    // 31 + その他
            'are',        // 32 例のアレ
            'diary',      // 33 日記
            'other',      // 34 その他
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

