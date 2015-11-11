<?php
/**
 * テキストファイルに書き込んだ順番でデータを読み込み、指定した時間に切り替える
 * 切り替える頻度は一日おき
 *
 * @access public
 * @author okutani
 * @category DataLoader
 * @package Class
 */
class SwitchingDataFromText
{
    /**
     * @var string $filePath  テキストファイルまでのパス
     * @var array  $data      読み込んだ画像名の配列
     * @var string $baseDate  経過日数の基準となる日付け
     * @var int    $swtTimeNo 切り替え時刻のスイッチ(切り替え時刻を超えていなければ-1がセットされる)
     */
    private $filePath  = "";
    private $data      = array();
    private $baseDate  = "1990/1/1";
    private $swtTimeNo = 0;

    /**
     * 自身のインスタンスを生成
     * @access public
     * @return object new self
     */
    public static function _() {
        return new self;
    }

    /**
     * 読み込む画像までのパスをセット
     *
     * @access public
     * @param  string $filePath
     * @return object $this
     */
    public function setFilePath($filePath="./data.txt")
    {
        // ディレクトリが存在するか確認
        if (file_exists($filePath)) {
            $this->filePath = $filePath;
        } else {
            trigger_error("$filePath not found...", E_USER_NOTICE);
        }

        return $this;
    }

    /**
     * 経過日数の基準となる$baseDateのセッター
     * デフォルト値は1990/1/1
     *
     * @access public
     * @param string $baseData 基準日
     * @return object $this
     */
    public function setBaseDate($baseDate="1990/1/1")
    {
        $this->baseDate = $baseDate;

        return $this;
    }

    /**
     * 切り替える時間を切り替える
     *
     * @access public
     * @return string $path 取得した画像パス
     */
    public function switchTime($switchTime="")
    {
        // スイッチする値が空ならエラー
        if ($switchTime === "") {
            trigger_error("switchDate is empty...", E_USER_NOTICE);
        }

        // 現在時刻のセット
        $nowTime = date("H:i", time());

        // 深夜00:00～switchTimeの間ならswtTimeNoに-1をセット
        if (strtotime($nowTime) >= strtotime("00:00") &&
            strtotime($nowTime) <= strtotime($switchTime)) {
            $this->swtTimeNo = -1;
        }

        return $this;
    }

    /**
     * 現在日時を基準にしてテキストデータを読み込む
     *
     * @access public
     * @return string $path 取得した画像パス
     */
    public function getData()
    {
        // テキストデータ(配列)の読み込み
        $this->leadTextData();

        // 選択したデータの件数を取得
        $dataCount = count($this->data);
        // 基準日と現在日時を比較して経過日数を取得
        $periodNo = $this->dayDiff($this->baseDate, date("Y/m/d", time()));

        // 深夜00:00～switchTimeの間なら経過日数をひとつずらす
        $periodNo += $this->swtTimeNo;

        // 配列の数で割ったあまりを添字として使う
        $indexNo = $periodNo % $dataCount;

        // 改行を取り除いて返す
        return str_replace(array("\r\n","\n","\r"), '', $this->data[$indexNo]);
    }

    /**
     * 基準日からの経過日数を取得する
     * 2038年問題？をクリアしていない
     *
     * @access private
     * @param  string $baseDate   基準になる日付(例:2015/1/1)
     * @param  string $targetDate 対象の日付(例:date("Y/m/d", time()))
     * @return string 経過日数
     */
    private function dayDiff($baseDate, $targetDate)
    {
        // 日付をUNIXタイムスタンプに変換
        $baseDate   = strtotime($baseDate);
        $targetDate = strtotime($targetDate);

        // 何秒離れているかを計算
        $secondDiff = abs($targetDate - $baseDate);

        // 日付けにして返す
        return $secondDiff / (60 * 60 * 24);
    }

    /**
     * テキストデータの読み込み
     *
     * @access private
     */
    private function leadTextData()
    {
        $this->data = file($this->filePath);
    }

}
