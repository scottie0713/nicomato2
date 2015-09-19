<?php

class IchibaShell extends AppShell
{
	public $uses = array('DataIchiba');

    /**
     * ニコニコ市場Dailyランキング取得
     *
     */
    public function main()
    {
        try {
			$ichiba = $this->getRss();
			$this->DataIchiba->deleteAll(array('1'=>'1'));
			$this->DataIchiba->saveAll($ichiba);
        } catch( Exeption $e ){
			echo "Exeption:", $e->getMessage(), "\n";
		}
    }


	private function getRss(){
		// Curlで取得開始
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$url = "http://ichiba.nicovideo.jp/ranking/earnings/all/d?rss=rss2";
		curl_setopt($ch, CURLOPT_URL, $url);
		$strXml = curl_exec($ch);

		if ( !preg_match("/^<\?xml.+/", $strXml) ){
			return false;
		}
		$xml = simplexml_load_string($strXml, 'SimpleXMLElement', LIBXML_NOCDATA);
		$res = array();
		foreach ($xml->channel->item as $i)
		{
			// rank, name
			$title = (string)$i->title;
			preg_match_all("/^第([0-9]+)位：(.+)$/", $title, $matches);
			if ( !isset($matched[1][0]) || !isset($matched[2][0]) ){
				continue;
			}
			$rank = $matches[1][0];
			$name = $matches[2][0];

			// link
			$description = (string)$i->description;
			preg_match_all("/www\.amazon\.co\.jp\/dp\/([0-9a-zA-Z]+).*creativeASIN=([0-9a-zA-Z]+)/", $description, $matches);
			if ( !isset($matched[1][0]) || !isset($matched[2][0]) ){
				continue;
			}
			$product = $matches[1][0];
			$asin    = $matches[2][0];
			$link_template = 'http://www.amazon.co.jp/gp/product/__PRODUCT__/ref=as_li_tf_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=__ASIN__&linkCode=as2&tag=kimukimi713-22';
			$link_template = str_replace("__PRODUCT__", $product, $link_template);
			$link = str_replace("__ASIN__", $asin, $link_template);

			// image
			$image = (string)$i->image;
			
			$res[] = array(
				'type'  => 'daily',
				'rank'  => $rank,
				'name'  => $name,
				'link'  => $link,
				'image' => $image,
			);
		}//foreach

		return $res;
	}//function

}
