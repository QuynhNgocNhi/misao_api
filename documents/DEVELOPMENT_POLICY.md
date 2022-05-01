# 開発方針

[< 戻る](../README.md)

## システム

- アプリケーションはAPIとして作成する
    - Responseは以下の形式とする

    ```json
    {
        "success": true,
        "message": "User logged in successfully",
        "data": { }
    }
    ```
