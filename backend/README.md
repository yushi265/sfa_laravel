# SFA的業務効率化アプリ
作成開始日：2021/01/25　　最終更新日：2021/02/13

## このプロジェクトについて
　私は現在、金融機関で営業職として仕事をしています。業務を行う中で、不便さを感じることが多々あります。それらを解決し、一つにまとめて管理できるようなシステムがあれば業務の効率化が図れると考えました。WEB系開発企業のバックエンドエンジニアとして転職を決意するにあたり、開発の練習として今回のアプリを制作することに決めました。

**現在の不便な点**
- それぞれの担当者との情報共有は基本、毎朝の会議で行うのみで、各自メモやコピーで管理
- 一人の顧客につき担当者が2人存在する場合があり、情報共有に注意が必要
- 営業する際のリストの作成は基本、紙媒体の顧客一覧表から目で見て抽出する。

## 今回の目的
- 普段の不便さを解決するようなアプリをつくる
- 内容的にはSFAに近いものをつくる
- 簡易的な業務効率化アプリを開発し、開発経験を積む
- 今学習中であり、今回使うLaravelの理解を深める
- バックエンド理解のため、フロントエンドは最低限で実装する
- ひとりアジャイル開発で行う

## 環境
- **開発言語**： PHP 8.0.0
- **使用フレームワーク**： Laravel 6.20.12
- **データベース**： MySQL 8.0.0
- **開発OS**： Windows 10 Home
- **バージョン管理**： GitHub

## 主な機能
- 顧客情報管理
- 営業進捗管理
- 成約管理機能
- 営業支援機能
- 日報管理
- タスク管理
- 天気予報API？
- 郵便番号から住所を取得するAPI?

## 開発
### データベース設計
- 必要となるデータベースは以下の通り  

        - データベース名：sfa_laravel
        - テーブル名
          - Users ユーザー情報
          - Customers 顧客情報
          - Progresses 交渉進捗
          - Schedules 予定管理
          - Appointments アポ予定

### 顧客情報管理機能
**概要**
- 顧客の名前、年齢、住所等の属性情報をリストで表示、並び替え・検索機能をつける（できれば非同期）。
- 顧客名をクリックすると詳細画面へ。法人と個人で表示を分ける。今までの交渉経過やアポ予定を表示。
- 同世帯は電話番号で紐づける(名寄せ)

**経過**
1. customersテーブルの作成とseeder,factoryでダミーレコード作成
2. 顧客一覧画面、登録画面の作成、CustomerRequest.phpでバリデーション
3. 顧客詳細、編集画面の作成。年齢計算の関数を作成し最新の年齢を表示するように。

**工夫点**
- customersテーブルに年齢カラムをつくらない
　年齢カラムを作ってしまうと経年時に年齢が反映されなくなってしまうため。そのため、顧客レコード取得時に年齢を計算する関数を用意し正確な年齢を反映できるようにした。

### 営業進捗管理
**概要**
- それぞれのユーザーが行った営業の進捗を登録し、情報を共有できるようにする。
- 進捗情報を顧客IDと紐づけてデータベースへ格納。顧客詳細画面でも表示できるようにする。
- 進捗の種類は、有効情報、営業進捗、契約成立で分ける。

**経過**
1. progressテーブルの作成。ユーザー、対象顧客とリレーションをし一覧表示
2. 進捗一覧、追加画面作成
3. 顧客詳細画面で進捗を活動履歴として表示。その際に最新順に並び替える

**工夫点**
- 顧客詳細画面で表示をする際、リレーション先の子テーブルを並び替える

//変更前 - 進捗を直接最新順で取得

    - CustomerController.php
            public function show(Customer $customer)
            {
                $customer->age = Customer::getAge($customer->birth);
                $progresses = Progress::latest()->get();
                return view('customers.show')->with(['customer' => $customer, 'progresses', $progresses]);  
            }
    - show.blade.php
            @forelse ($progresses as $progress)
                {{ $progress->yourdata }}
            @empty
                進捗がありません
            @endforelse

//変更後 - 直接取得せず、リレーションで並び替えて表示

    - CustomerController.php
            public function show(Customer $customer)
                {
                    $customer->age = Customer::getAge($customer->birth);
                    return view('customers.show')->with('customer', $customer);
                }
    - show.blade.php
            @forelse ($customer->progresses()->orderby('id', 'desc')->get() as $progress)
                {{ $progress->yourdata }}
            @empty
                進捗がありません
            @endforelse

### 成約管理
**概要**
- 各ユーザーが成約データを管理する
- 今回、簡略化のため3つの種別で分ける。普通預金、定期預金、融資の3つ。
- 顧客詳細画面でも表示できるようにする

**経過**
1. contractsテーブルを作成。ユーザー、カスタマーとリレーション。
2. 一覧ページ、検索機能を作成。
3. 顧客詳細画面に預金種別ごとに成約した合計金額を表示。
4. 成約を追加したときに、進捗テーブルにも「契約成立」としてデータを挿入。

**工夫点**
- モデルContract.phpにて対象顧客の預金合計を取得する関数を作成。連想配列に入れたがもっと良い方法がある気がする。

        public static function getDepositStatus($id)
            {
                $status = [];
                $status['ordinary'] = self::where('customer_id', $id)->where('contract_type', 2)->sum('amount');
                $status['time'] = self::where('customer_id', $id)->where('contract_type', 3)->sum('amount');
                $status['loan'] = self::where('customer_id', $id)->where('contract_type', 4)->sum('amount');

                return $status;
            }

### 管理者権限
**概要**
- ユーザーを*一般、管理者、システム管理者*に分けて権限を与え使える機能を制限する。
- システム管理者のみが使用できるのは権限の変更
- 管理者以上で使用できるのは、顧客追加・編集、成約追加の機能。
- そのほかは一般ユーザーも使用できるようにする。

**経過**
1. usersテーブルにroleカラムを追加。*一般 = 10、管理者 = 5、システム管理者 = 1*で管理する。
2. ゲート機能を利用して、roleの値ごとに権限を与える。
3. ブレードないも *@can* を使用して権限によって表示を変更。
4. システム管理者権限でユーザーの役割を変更できるように
5. システム管理者のみがユーザー登録できるようにコード書き換え
6. ホーム画面追加、役割によって表示を変えた


**工夫点**
- *CustomerController@create*の404エラー
　ルートをいじっていたら404エラーに。原因はURLがかぶっていたため。ルートグループの順番を入れ替えて解決

        // 全ユーザ
        Route::group(['middleware' => ['auth', 'can:user-higher']], function () {
            Route::get('/customers', 'CustomerController@index');
            Route::get('/customers/{customer}', 'CustomerController@show'); ←←←ここ
        });
        // 管理者以上
        Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
            Route::get('/customers/create', 'CustomerController@create');  ←←←ここ
            Route::post('/customers', 'CustomerController@store');
            Route::get('/customers/{customer}/edit', 'CustomerController@edit');
            Route::patch('/customers/{customer}', 'CustomerController@update');
        });
- リクエストのなかで変数を使いたかったので、下記のようにした。

        $request->input('user_admin_'.$user->id)

- ユーザー登録をシステム管理者に限定するためコード書き換え
    - App\Http\Controllers\Auth\RegisterController.php
        
            〇リダイレクト無効化、コンストラクタを書き換え
            // protected $redirectTo = RouteServiceProvider::HOME;

            public function __construct()
            {
                // $this->middleware('guest');
                $this->middleware(['auth', 'can:system-only']);
            }

    - Illuminate\Foundation\Auth\RegistersUsers.php

            public function register(Request $request) {
                $this->validator($request->all())->validate();
                event(new Registered($user = $this->create($request->all())));

                〇追加ユーザーログインを無効化
                // $this->guard()->login($user);
                // return $this->registered($request, $user)
                // ?: redirect($this->redirectPath());

                〇リダイレクト先を追加
                return redirect('/admin');
            }

### 営業支援機能
**概要**
- 営業担当者が顧客情報を閲覧したときに推進すべき商品を提案する機能
- 提案内容は定期預金、年金、思いつき次第追加

**経過**
1. Customer.phpにgetSuggests関数作成
2. 顧客詳細画面に提案として表示

## 課題
　検索時のページネートができない

**原因**
- 検索をPOSTで実装したためページネート時にデータを受け渡しできない。

**解決策**
- GETで検索を実行する
- searchページに返すのではなくindexページに返す
- {{ $customers->appends(request()->input())->links() }} とする
