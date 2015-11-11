# PHP Switching Data From Text

PHPで利用できる、テキストデータから値を参照して日付けで切り替えるやつ

---

## 説明

テキストファイルに書き込まれたデータを読み込み、一日おきに切り替える。From TextとなっているがText以外でもOK。

切り替えたい時間を指定できる。

基準となる日付けを用意して、現在の日付けを比較することで、その値を使って画像を切り替えている。

たとえば

```
2015/1/1(基準日)～2015/1/11(現在)　→　差は10

10 % 3(データの数) = 1
→ 次の日は2、その次は割り切れるので0...
→ これらを添え字として使って、読み込むデータを切り替えている。
```

## 使い方

下記例: テキストファイルに書き込んだ画像名を取得して、一日置きに切り替えている

```php
// SwitchingDataFromText読み込み
require_once(__DIR__."/SwitchingDataFromText.class.php");

$data = SwitchingDataFromText::_()->setFilePath("./data.txt") #テキストデータのパス指定
                                  ->setBaseDate("2015/10/11") #切り替え用基準日(なんでもよい)
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
```

***

* setFilePath()

テキストファイルまでのパスを指定
* setBaseDate("2015/10/10")

基準となる日付けを設置。日付けならなんでもOK。空だと1990/1/1がセットされる
* switchTime("8:00")

画像を切り替えたい時間をセット
* getData()

データを取得

author: okutani
