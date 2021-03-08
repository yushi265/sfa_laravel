## 業務効率化アプリ　アップデート

### ○docker導入

### ○成約画面の検索強化
- 従来、状態の検索のみであった。
- 入力された顧客名での検索を追加。複数条件で検索できるように。

### ○顧客詳細画面に世帯情報を表示
- 顧客詳細に世帯を表示させて、家族に対する提案を追加したい。
- 対象顧客とtelが一致する顧客（対象顧客）を検索し表示。
- 家族に学生がいたら、奨学ローンの提案を表示するように追加。

### ○データベース設計を変更
- 顧客テーブルの職業、進捗の状態、成約の種類をナンバー管理に変更
- 苦労点：id以外を外部キーにしようとしたら上手くいかなかった。→　unique()にしていなかった。
- リクエストのカラム名変更し忘れ
- リレーションhasOneで第二引数、第三引数指定し忘れ
- 追加や編集時のセレクトをforeachで回せるようになった

### ○N＋1問題解消
- viewでリレーションで取り出していたのをコントローラーで事前に取り出すようにした。
