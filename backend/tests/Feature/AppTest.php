<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\User;

class AppTest extends TestCase
{

    public const SYSTEM_ADMIN = 1;
    public const ADMIN = 5;
    public const GENERAL = 10;
    /**
     * ゲストユーザーテスト
     *
     * @return void
     */
    public function testGuestUser()
    {
        $response = $this->get('/login');
        $response->assertStatus(200)->assertSee('ログイン');

        $response = $this->get('/');
        $response->assertStatus(302);

        $response = $this->get('/customers');
        $response->assertStatus(302);

        $response = $this->get('/customers/1');
        $response->assertStatus(302);

        $response = $this->get('/customers/1/edit');
        $response->assertStatus(302);

        $response = $this->get('/progresses');
        $response->assertStatus(302);

        $response = $this->get('/progresses/1/edit');
        $response->assertStatus(302);

        $response = $this->get('/contracts');
        $response->assertStatus(302);

        $response = $this->get('/contracts/1/edit');
        $response->assertStatus(302);

        $response = $this->get('/admin');
        $response->assertStatus(302);

        $response = $this->get('/no_route');
        $response->assertStatus(404);
    }

    /**
     * 一般ユーザーテスト
     *
     * @return void
     */
    public function testGeneralUser()
    {
        // テストユーザー作成
        $user = factory(User::class)->create([
            'name' => '一般ユーザー',
            'email' => 'general@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => self::GENERAL,
        ]);
        // ログインテスト
        $response = $this->actingAs($user)->get('/login');
        $response->assertStatus(302);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200)->assertViewIs('home')->assertSee('追加する');

        // 顧客管理テスト
        $response = $this->actingAs($user)->get('/customers');
        $response->assertStatus(200)->assertViewIs('customers.index')->assertSee('顧客データベース');

        $response = $this->actingAs($user)->get('/customers/1');
        $response->assertStatus(200)->assertViewIs('customers.show')->assertSee('鈴木達也');

        $response = $this->actingAs($user)->get('/customers/create');
        $response->assertStatus(403);

        $response = $this->actingAs($user)->get('/customers/1/edit');
        $response->assertStatus(403);

        // 進捗管理テスト
        $response = $this->actingAs($user)->get('/progresses');
        $response->assertStatus(200)->assertViewIs('progresses.index')->assertSee('進捗一覧');

        $response = $this->actingAs($user)->get('/progresses/create');
        $response->assertStatus(200)->assertViewIs('progresses.create')->assertSee('選んでください');

        $response = $this->actingAs($user)->get('/progresses/1/edit');
        $response->assertStatus(403);

        $response = $this->actingAs($user)->post('/progresses', [
            'user_id' => $user->id,
            'customer_id' => '1',
            'status_id' => '1',
            'body' => '進捗のテスト中です！！',
            'created_at' => now(),
        ]);

        $readProgress = \App\Progress::where('body', '進捗のテスト中です！！')->first();
        $this->assertNotNull($readProgress);

        $response = $this->actingAs($user)->patch('/progresses/' . $readProgress->id, [
            'user_id' => $user->id,
            'customer_id' => '1',
            'status_id' => '5',
            'body' => '進捗の編集のテスト中です！！',
            'created_at' => now(),
        ]);
        $response->assertStatus(403);

        $editedProgress = \App\Progress::where('body', '進捗の編集のテスト中です！！')->first();
        $this->assertNull($editedProgress);

        $response = $this->actingAs($user)->delete('/progresses/' . $readProgress->id);
        $response->assertStatus(403);

        // 成約管理テスト
        $response = $this->actingAs($user)->get('/contracts');
        $response->assertStatus(200)->assertViewIs('contracts.index')->assertSee('成約一覧');

        $response = $this->actingAs($user)->get('/contracts/1/edit');
        $response->assertStatus(403);

        $response = $this->actingAs($user)->delete('/contracts/1');
        $response->assertStatus(403);

        // 権限管理テスト
        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403)->assertDontSee('権限一覧');

        $response = $this->actingAs($user)->get('/no_route');
        $response->assertStatus(404);

        $user->delete();
    }

    /**
     * 管理者ユーザーテスト
     *
     * @return void
     */
    public function testAdminUser()
    {
        $user = factory(User::class)->create([
            'name' => '管理者ユーザー',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => self::ADMIN,
        ]);

        // ログインテスト
        $response = $this->actingAs($user)->get('/login');
        $response->assertStatus(302);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200)->assertViewIs('home')->assertSee('追加する');

        // 顧客管理テスト
        $response = $this->actingAs($user)->get('/customers');
        $response->assertStatus(200)->assertViewIs('customers.index')->assertSee('顧客データベース');

        $response = $this->actingAs($user)->get('/customers/1');
        $response->assertStatus(200)->assertViewIs('customers.show')->assertSee('鈴木達也');

        $response = $this->actingAs($user)->get('/customers/create');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/customers/1/edit');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/progresses');
        $response->assertStatus(200)->assertViewIs('progresses.index')->assertSee('進捗一覧');

        $response = $this->actingAs($user)->get('/progresses/create');
        $response->assertStatus(200)->assertViewIs('progresses.create')->assertSee('選んでください');

        $response = $this->actingAs($user)->get('/progresses/1/edit');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post('/progresses', [
            'user_id' => $user->id,
            'customer_id' => '1',
            'status_id' => '1',
            'body' => '進捗のテスト中です！！',
            'created_at' => now(),
        ]);

        $readProgress = \App\Progress::where('body', '進捗のテスト中です！！')->first();
        $this->assertNotNull($readProgress);

        $response = $this->actingAs($user)->patch('/progresses/' . $readProgress->id, [
            'user_id' => $user->id,
            'customer_id' => '1',
            'status_id' => '5',
            'body' => '進捗の編集のテスト中です！！',
            'created_at' => now(),
        ]);
        $response->assertRedirect('/progresses');

        $editedProgress = \App\Progress::where('body', '進捗の編集のテスト中です！！')->first();
        $this->assertNotNull($editedProgress);

        $response = $this->actingAs($user)->delete('/progresses/' . $editedProgress->id);
        $response->assertRedirect('/progresses');

        $deletedProgress = \App\Progress::where('body', '進捗の編集のテスト中です！！')->first();
        $this->assertNull($deletedProgress);

        $response = $this->actingAs($user)->get('/contracts');
        $response->assertStatus(200)->assertViewIs('contracts.index')->assertSee('成約一覧');

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403)->assertDontSee('権限一覧');

        $response = $this->actingAs($user)->get('/no_route');
        $response->assertStatus(404);

        $user->delete();
    }

    /**
     * システム管理者ユーザーテスト
     *
     * @return void
     */
    public function testSystemAdminUser()
    {
        $user = factory(User::class)->create([
            'name' => 'システム管理ユーザー',
            'email' => 'system_admin@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => self::SYSTEM_ADMIN,
        ]);

        $response = $this->actingAs($user)->get('/login');
        $response->assertStatus(302);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200)->assertViewIs('home')->assertSee('追加する');

        $response = $this->actingAs($user)->get('/customers');
        $response->assertStatus(200)->assertViewIs('customers.index')->assertSee('顧客データベース');

        $response = $this->actingAs($user)->get('/progresses');
        $response->assertStatus(200)->assertViewIs('progresses.index')->assertSee('進捗一覧');

        $response = $this->actingAs($user)->get('/contracts');
        $response->assertStatus(200)->assertViewIs('contracts.index')->assertSee('成約一覧');

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(200)->assertViewIs('users.admin_index')->assertSee('権限一覧');

        $response = $this->actingAs($user)->get('/no_route');
        $response->assertStatus(404);

        $user->delete();
    }

    /**
     * Usersテーブルのテスト
     *
     * @return void
     */
    public function testUsers()
    {
        $user = new \App\User;
        $user->name = "テストユーザー";
        $user->email = "test@test.com";
        $user->password = \Hash::make('password');
        $user->save();

        $readUser = \App\User::where('name', 'テストユーザー')->first();
        $this->assertNotNull($readUser);            // データが取得できたかテスト
        $this->assertTrue(\Hash::check('password', $readUser->password)); // パスワードが一致しているかテスト

        $admin_role_num = 5;
        $user->role = $admin_role_num;
        $user->save();
        $this->assertEquals($admin_role_num, $user->role);


        \App\User::where('email', 'test@test.com')->delete(); // テストデータの削除
    }

    /**
     * Customersテーブルのテスト
     *
     * @return void
     */
    public function testCustomers()
    {
        $customer = new \App\Customer([
            'name' => 'テストカスタマー',
            'ruby' => 'テストカスタマー',
            'gender_id' => '2',
            'birth' => '2020-01-01',
            'tel' => '0123456789',
            'address' => '千葉県千葉市千葉1000',
            'mail' => 'customer@test.com',
            'job_id' => '1',
            'company' => '株式会社テスト'
        ]);
        $customer->save();

        $readCustomer = \App\Customer::where('name', 'テストカスタマー')->first();
        $this->assertNotNull($readCustomer);

        $customer->name = 'テスト顧客';
        $customer->ruby = 'テストコキャク';
        $customer->gender_id = '1';
        $customer->birth = '2000-12-31';
        $customer->tel = '9876543210';
        $customer->address = '千葉県千葉市千葉5000';
        $customer->mail = 'customer_edited@test.com';
        $customer->job_id = '4';
        $customer->company = '';

        $customer->save();

        $editedCustomer = \App\Customer::where('name', 'テスト顧客')
                                        ->where('ruby', 'テストコキャク')
                                        ->where('gender_id', '1')
                                        ->where('birth', '2000-12-31')
                                        ->where('tel', '9876543210')
                                        ->where('address', '千葉県千葉市千葉5000')
                                        ->where('mail', 'customer_edited@test.com')
                                        ->where('job_id', '4')
                                        ->where('company', '')
                                        ->first();
        $this->assertNotNull($editedCustomer);

        \App\Customer::where('name', 'テスト顧客')->delete();
    }

    /**
     * Progressesテーブルのテスト
     *
     * @return void
     */
    // public function testProgresses()
    // {

    // }
}
