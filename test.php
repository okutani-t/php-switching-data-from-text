<?php
// SwitchingDataFromText読み込み
require_once(__DIR__."/SwitchingDataFromText.class.php");
// デバッグ用
function d()
{
    echo '<pre style="background:#fff;color:#333;border:1px solid #ccc;margin:2px;padding:4px;font-family:monospace;font-size:12px;line-height:18px">';
    foreach (func_get_args() as $v) {
        var_dump($v);
    }
    echo '</pre>';
}

$data = SwitchingDataFromText::_()->setFilePath("./data.txt") #テキストデータのパス指定
                                  ->setBaseDate("2015/10/11") #切り替え用基準日
                                  ->switchTime("8:00")        #切り替え用時刻
                                  ->getData();                #データの取得

// 相対パスでセット
$imgPath = "./img/".$data;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SwitchingDataFromText test</title>
</head>
<style>
body {
    width: 940px;
    margin: 0 auto;
}
</style>
<body>
    <h1>Switching Data From Textのテスト</h1>
    <img src="<?= $imgPath ?>" width="200" height="200">
</body>
</html>
