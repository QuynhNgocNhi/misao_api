# Twilioを利用したSms送信

[< 戻る](../DEVELOPMENT_GUIDE.md)

## 利用コンポーネント

`app/Components/Twilio/SmsComponent.php`

## 事前準備

.envファイルで環境変数`TWILIO_*`に値をセットしてください。

`TWILIO_SID`, `TWILIO_TOKEN`, `TWILIO_FROM`だけで動作しますが、<br>
`API_KEY`, `API_SECRET`がセットされていれば`TWILIO_SID`, `TWILIO_TOKEN`は不要です。

使用するアプリケーションごとにAPIKEYを発行して、そちらを利用するほうが安全です。

## 使用例

`tests/Unit/Component/Twilio/SmsComponentTest.php`を参照してください。

## Tips

