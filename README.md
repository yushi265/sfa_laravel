## 業務効率化アプリ　アップデート

### ○docker導入

### ○顧客詳細画面に世帯情報を表示
- 顧客詳細に世帯を表示させて、家族に対する提案を追加したい。
- 対象顧客とtelが一致する顧客（対象顧客）を検索し表示。
- 家族に学生がいたら、奨学ローンの提案を表示するように追加。

### ○データベース設計を変更
- 顧客テーブルの職業、進捗の状態、成約の種類をナンバー管理に変更
- 苦労点：id以外を外部キーにしようとしたら上手くいかなかった。→　unique()にしていなかった。
- リクエストのカラム名変更し忘れ、バリデーションが通らない
- リレーションhasOneで第二引数、第三引数指定し忘れ
- 追加や編集時のセレクトをforeachで回せるようになった

### ○N＋1問題解消
- viewでリレーションで取り出していたのをコントローラーで事前に取り出すようにした。

### ○検索機能の強化
- 成約画面の検索強化
  - 従来、状態の検索のみであった。
  - 入力された顧客名での検索を追加。複数条件で検索できるように。
- 顧客を検索する際に、性別、職業、年齢で絞り込み可に
- 全ての検索にバリデーションを追加、エラー表示も追加
- 年齢を生年月日に変換するのに苦労

### ○テストコード
- アクセス可能なルーティングをユーザーのroleごとにテスト
- 顧客電話番号のバリデーション不備を発見
- 命令網羅しかできなかった、分岐網羅も後々
- getメソッドのときはassertStatus()、それ以外はリダイレクトさせるのでassertRedirect()

### ○自動テスト(circleCI)
- 開発効率化のため自動テストの導入
- configファイルの理解不足
- mysqlの接続で苦戦(environment設定)

### ○デプロイの自動化
- 開発効率化や人為的なエラーを減らすために自動化
- インフラの知識が全くなくかなり苦労
- パーミッションエラー発生
  - chmod 600 id_rsa で解決
- error: cannot open .git/FETCH_HEAD: Permission denied発生
  - sudo chown -R ユーザ名 ./ でプロジェクトの所有者を変更
 
### ＜今後の課題＞
- リファクタリング
- API導入（地図？天気？）
- 便利機能（西暦⇄和暦変換、年齢計算、タスク管理機能、スケジュール機能、slack的コミュニケーションツール）
- dockerの勉強、CircleCIの勉強
