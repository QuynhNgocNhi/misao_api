# Excelファイルのインポート・エクスポート

[< 戻る](../DEVELOPMENT_DOC.md)

## 利用コンポーネント

`app/Components/Excel/`配下のクラス

## 事前準備

.envファイルで環境変数`AWS_ACCESS_KEY_ID` `AWS_SECRET_ACCESS_KEY` `AWS_DEFAULT_REGION` `AWS_S3_BUCKET`に値をセットしてください。

## 使用例

### インポート

1. `app/Components/Excel/Import/ImportComponent.php`を継承したクラスを作成する。
2. 継承したクラスではmodelメソッドをオーバーライドし、`app/Components/Excel/Import/SampleImport.php`に習ってインポートしたいモデルを返却する。
3. 使用したいクラスで先程作成したimportクラスを呼び出し、ヘッダ行に入るキー名をimportクラスで指定した順番で`$this->keys`に代入する。
4. `tests/Unit/Component/Excel/Import/SampleImportComponentTest.php`に習って`Excel::import`を実行する

### エクスポート

1. `app/Components/Excel/Export/ExportComponent.php`を継承したクラスを作成する。
2. 継承したクラスではcollectionメソッドをオーバーライドし、`app/Components/Excel/Export/SampleExport.php`に習ってエクスポートしたいモデルを返却する。
3. S3にファイルをエクスポートする場合、処理完了をメール通知するため`app/Components/Excel/Export/ExportComponent/Notify/NotifyUserOfCompletedExport.php`
   に習ってキュー実行されるジョブを作成する。
4. 処理を呼び出す場合は`app/UseCases/SampleExportUseCase.php`を参考に処理を書く

## Tips

