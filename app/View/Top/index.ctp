<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->script('top/index.js', array('inline'=>false));
//echo $this->Html->css('page/regist.css');
?>
<div>
	<h2>更新情報</h2>
	<h3>2018/01/27 更新情報をTwitterにしました。</h3>
	<div style="margin-left:20px;">
	基本放置な当サイトですが、更新情報とかこちらに載せます。掲示板やお知らせの代わりに。
	<div style="border:1px solid; width:400px;">
	<!-- start TweetsWind code -->
	<iframe     scrolling="no" frameborder="0" id="twitterWindIframe"     style="width:400px;height:400px; border:none;"     src="http://www.tweetswind.com/show?option=%7B%22isOnlyMe%22%3A%20%22false%22%2C%20%22twitterwind_frame_width%22%3A%20%22400%22%2C%20%22twitterwind_frame_height%22%3A%20%22400%22%2C%20%22twitterwind_frame_border%22%3A%20%22none%22%2C%20%22twitterwind_frame_border_color%22%3A%20%22C0DEED%22%2C%20%22twitterwind_base_font_size%22%3A%20%2212%22%2C%20%22twitterwind_logoimage%22%3A%20%22blueonwhite%22%2C%20%22twitterwind_username%22%3A%20%22on%22%2C%20%22twitterwind_username_bgcolor%22%3A%20%22FFFFFF%22%2C%20%22twitterwind_username_color%22%3A%20%22333333%22%2C%20%22twitterwind_username_follow%22%3A%20%22on%22%2C%20%22twitterwind_max_length%22%3A%20%2239%22%2C%20%22twitterwind_logo_bgcolor%22%3A%20%22FFFFFF%22%2C%20%22twitterwind_twit%22%3A%20%22on%22%2C%20%22twitterwind_twit_scroll_color%22%3A%20%22C0DEED%22%2C%20%22twitterwind_twit_scroll_bg_color%22%3A%20%22FFFFFF%22%2C%20%22twitterwind_twit_bgcolor%22%3A%20%22FFFFFF%22%2C%20%22twitterwind_twit_color%22%3A%20%22333333%22%2C%20%22twitterwind_twit_link_color%22%3A%20%220084B4%22%2C%20%22twitterwind_opacity%22%3A%20%22off%22%2C%20%22twitterwind_follower%22%3A%20%22inherit%22%2C%20%22twitterwind_follower_bgcolor%22%3A%20%22FFFFFF%22%2C%20%22usn%22%3A%20%22162498%22%7D"     > </iframe>
	<!--利用規約に従ってページ内に必ずリンクを表示してください-->
	<div style="font-size:12px; text-align:right; width:400px"><a target="_blank" href="http://www.tweetswind.com">TweetsWind</a></div> 
	<!-- end TweetsWind code -->
	</div>
	</div>
	<br />
	<br />

	<h2>はじめに</h2>
	<h3>にこまと！2.0について</h3>
	<div style="margin-left:20px; font-size:14px;">
		<span style="color:blue">「気になるマイリストに動画が追加されたかな？」</span><br/>
		<span style="color:blue">「気になるユーザが動画投稿したかな？」</span><br/>
		これを一度にチェックできるページを作れます。<br/>
		既に完結したマイリストも登録して保存しておくことができます。
	</div>
	<h3>チェック登録できるもの</h3>
	<div style="margin-left:20px; font-size:14px;">
		<span style="color:blue;">
		①公開マイリスト<br/>
		②ユーザ投稿動画<br/>
		③チャンネルのブロマガ<br/>
		④チャンネル生放送<br/>
		</span>
		<span style="color:red;">
			※ブロマガと生放送は同じチャンネルでも別扱いとなります。
		</span>
	</div>
	<h3>スマートフォン版</h3>
	<div style="margin-left:20px; font-size:14px;">
		URLは同じです。機能はPC版とほぼ同じです。
	</div>
	<h3>旧にこまと！(ニコニコ動画マイリストまとめてチェッカー)を利用している方へ</h3>
	<div style="margin-left:20px; font-size:14px;">
		<span style="color:red">
		    データの互換性はありません。(お互いにデータは独立しています)<br/>
		</span>
	</div>
	<br />
	<br />


	<h2>更新チェックページ新規作成</h2>
	<h3>ページ名 <span style="color:red">&lt;必須&gt;</span></h3>
	<div style="margin-left:20px; font-size:14px;">
		自分のページのタイトルになります。お好きに記入してください。<br/>
		<input id="title" type="text" style="width:400px;" value="" /><br/>
	</div>
	<h3>登録するマイリストURL/ユーザ投稿動画URL <span style="color:red">&lt;必須&gt;</span></h3>
	<div style="margin-left:20px; font-size:14px;">
		次の形でURLを入れてください。<br/>
		<span style="color:#060;">
		公開マイリスト: http://www.nicovideo.jp/mylist/【数字】<br/>
		ユーザ投稿動画: http://www.nicovideo.jp/user/【数字】<br/>
		CHのブロマガ　: http://ch.nicovideo.jp/【文字列】/blomaga<br/>
		CHの生放送　　: http://ch.nicovideo.jp/【文字列】/live<br/>
		</span>
		<span style="color:orange">※１行に１ＵＲＬでお願いします。</span><br/>
		<textarea id="url" rows="10" cols="60"></textarea>
	</div>
	<h3>編集用パスワード</h3>
	<div style="margin-left:20px; font-size:14px;">
		<span style="color:red">※半角英数字20文字まで</span><br/>
		なくてもOKです。他人に編集されるのが嫌な人は、パスワードを設定してください。<br/>
	    <input id="password" type="text" value="" />&nbsp;
	</div>
	<h3>登録する！</h3>
	<div style="margin-left:20px; font-size:14px;">
	    <input id="regist_submit" type="submit" value="登録" />
	</div>
    <br />
	<br />

	<h2>各種仕様</h2>
	<h3>更新チェックについて</h3>
	<div style="margin-left:20px; font-size:14px;">
	以前は
	基本的に<b>最終投稿日時が古い程、更新チェック頻度が落ちます。</b><br/>
	(F5連打などされた場合に公式に負荷をかけないようにするための配慮です)<br/>
	<br/>
	現在暫定的に次のように設定されていますが、状況によっては変更することがあります。<br/>
	・ 1ヶ月以内に投稿があったものは、最終チェック時から<span style="color:red">10分間</span>は次回更新チェックできません。<br/>
	・ 1ヶ月～半年前に投稿があったものは、最終チェック時から<span style="color:red">12時間</span>は次回更新チェックできません。<br/>
	・ 半年以上投稿がないものは、最終チェック時から<span style="color:red">24時間</span>は次回更新チェックできません。<br/>
	</div>
	<br />
	<br />

	<h2>困ったとき</h2>
	<h3>自分の作ったマイページがどこにあるかわからない・ブックマークし忘れた</h3>
	<div style="margin-left:20px; font-size:14px;">
	「ページ一覧」から、あなたの作ったページを探してください。<br/>
	自分にとってわかりやすいタイトルにしておけば探しやすいと思います。
	</div>

	<h3>自分の作ったマイページ、もう要らないので削除したい</h3>
	<div style="margin-left:20px; font-size:14px;">
	削除機能はありません。放置してください。<br/>
	一定期間放置されたページを管理人が削除します。
	</div>
	<br />
	<br />

	<h3>パスワード忘れた・・・</h3>
	<div style="margin-left:20px; font-size:14px;">
	お手数ですが、新しくページを新規作成してください。<br/>
	編集ページの一番下に「登録されたURL一覧」があります。<br/>
	そのURLのリストをコピーすれば、簡単に新しいページを作る事が出来ます。<br/>
	「パスワード忘れたので教えてくれ」との問い合わせにはお答えできませんのでご了承ください。
	</div>

</div>
