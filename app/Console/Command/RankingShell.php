<?php

class RankingShell extends AppShell
{

    public $uses = array('Xml', 'RankingNicovideo');

    /**
     * Dailyランキング取得
     *
     */
    public function main($type = 2)
    {
        $data = array();
        try {
            for( $category=0; $category<=34; $category++ )
            {
                $xml = $this->Xml->getRanking($type, $category);
                $rank=1;
                foreach ( $xml->entry as $entry )
                {
                    $data[] = array(
                            'type'      => $type,
                            'category'  => $category,
                            'rank'      => $rank,
                            'movie_id'  => $this->getMovieId((string)$entry->id),
                            'title'     => (string)$this->formatTitle((string)$entry->title),
                            'published' => (string)$entry->published,
                            'updated'   => (string)$entry->updated,
                            'content'   => (string)$entry->content,
                            );
                    $rank++;
                    if ($rank>100) break;
                }
            }

            // INSERT
            $this->RankingNicovideo->deleteAll(array('RankingNicovideo.type' => $type));
            $this->RankingNicovideo->saveAll($data);

            $this->out("END.");

        } catch (Exception $e) {
            $this->out($e);
        }
    }

    // title整形
    private function formatTitle($str) {
        return mb_ereg_replace("第[0-9]+位：","",$str);
    }

    private function getMovieId($str)
    {
        //tag:nicovideo.jp,2014-07-27:/watch/sm24100941
        $s1 = explode( ':', $str );
        $s2 = explode( '/', $s1[2]);
        return $s2[2];
    }
}
