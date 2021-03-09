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

        $response = $this->actingAs($user)->get('/contracts/create');
        $response->assertStatus(403);

        $response = $this->actingAs($user)->get('/contracts/1/edit');
        $response->assertStatus(403);

        $response = $this->actingAs($user)->delete('/contracts/1');
        $response->assertStatus(403);

        // 権限管理テスト
        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403)->assertDontSee('権限一覧');

        $response = $this->actingAs($user)->get('/register');
        $response->assertStatus(403);

        // 存在しないルーティング
        $response = $this->actingAs($user)->get('/no_route');
        $response->assertStatus(404);

        // データ削除
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

        $response = $this->actingAs($user)->get('/customers/create');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post('/customers', [
            'name' => 'テスト顧客',
            'ruby' => 'テストカスタマー',
            'gender_id' => '1',
            'birth' => '2020-01-01',
            'tel' => '0123456789',
            'address' => '千葉県千葉市千葉1000',
            'mail' => 'customer@test.com',
            'job_id' => '1',
            'company' => '株式会社テスト'
            ]);
        $response->assertRedirect('/customers');
        $readCustomer = \App\Customer::where('name', 'テスト顧客')->first();
        $this->assertNotNull($readCustomer);

        $response = $this->actingAs($user)->get('/customers/' . $readCustomer->id);
        $response->assertStatus(200)->assertViewIs('customers.show')->assertSee('テスト顧客');

        $response = $this->actingAs($user)->get('/customers/1/edit');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->patch('/customers/' . $readCustomer->id, [
            'name' => 'テスト編集顧客',
            'ruby' => 'テストヘンシュウカスタマー',
            'gender_id' => '2',
            'birth' => '2000-01-01',
            'tel' => '0123456789',
            'address' => '千葉県千葉市千葉5000',
            'mail' => '',
            'job_id' => '4',
            'company' => ''
        ]);
        $response->assertRedirect('/customers/' . $readCustomer->id);

        $editedCustomer = \App\Customer::where('name', 'テスト編集顧客')->first();
        $this->assertNotNull($editedCustomer);

        // 進捗管理テスト
        $response = $this->actingAs($user)->get('/progresses');
        $response->assertStatus(200)->assertViewIs('progresses.index')->assertSee('進捗一覧');

        $response = $this->actingAs($user)->get('/progresses/create');
        $response->assertStatus(200)->assertViewIs('progresses.create')->assertSee('選んでください');

        $response = $this->actingAs($user)->get('/progresses/1/edit');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post('/progresses', [
            'user_id' => $user->id,
            'customer_id' => $editedCustomer->id,
            'status_id' => '1',
            'body' => '進捗のテスト中です！！',
            'created_at' => now(),
        ]);

        $readProgress = \App\Progress::where('body', '進捗のテスト中です！！')->first();
        $this->assertNotNull($readProgress);

        $response = $this->actingAs($user)->patch('/progresses/' . $readProgress->id,
        [
            'user_id' => $user->id,
            'customer_id' => $editedCustomer->id,
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

        // 成約管理テスト
        $response = $this->actingAs($user)->get('/contracts');
        $response->assertStatus(200)->assertViewIs('contracts.index')->assertSee('成約一覧');

        $response = $this->actingAs($user)->get('/contracts/create');
        $response->assertStatus(200)->assertViewIs('contracts.create')->assertSee('選んでください');

        $response = $this->actingAs($user)->post('/contracts', [
            'customer_id' => $editedCustomer->id,
            'contract_type_id' => '9',
            'amount' => '4242424242',
            'due_date' => '2024-01-12',
            'created_at' => '2021-01-12 10:00:00',
        ]);
        $response->assertRedirect('/contracts');
        $readContract = \App\Contract::where('amount', '4242424242')->first();
        $this->assertNotNull($readContract);

        $response = $this->actingAs($user)->get('/contracts/' . $readContract->id . '/edit');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->patch('/contracts/' . $readContract->id, [
            'customer_id' => $editedCustomer->id,
            'contract_type_id' => '6',
            'amount' => '2424242424',
            'due_date' => '2025-01-12',
            'created_at' => '2021-01-12 10:00:00',
        ]);
        $response->assertRedirect('/contracts');
        $editedContract = \App\Contract::where('amount', '2424242424')->first();
        $this->assertNotNull($editedContract);

        $response = $this->actingAs($user)->delete('/contracts/' . $editedContract->id);
        $response->assertRedirect('/contracts');

        // 権限管理テスト
        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403)->assertDontSee('権限一覧');

        $response = $this->actingAs($user)->get('/register');
        $response->assertStatus(403);

        // 存在しないルーティング
        $response = $this->actingAs($user)->get('/no_route');
        $response->assertStatus(404);

        // データ削除
        $editedCustomer->delete();
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

        // ログインテスト
        $response = $this->actingAs($user)->get('/login');
        $response->assertStatus(302);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200)->assertViewIs('home')->assertSee('追加する');

        // 顧客管理テスト
        $response = $this->actingAs($user)->get('/customers');
        $response->assertStatus(200)->assertViewIs('customers.index')->assertSee('顧客データベース');


        $response = $this->actingAs($user)->get('/customers/create');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post('/customers', [
            'name' => 'テスト顧客',
            'ruby' => 'テストカスタマー',
            'gender_id' => '1',
            'birth' => '2020-01-01',
            'tel' => '0123456789',
            'address' => '千葉県千葉市千葉1000',
            'mail' => 'customer@test.com',
            'job_id' => '1',
            'company' => '株式会社テスト'
        ]);
        $response->assertRedirect('/customers');
        $readCustomer = \App\Customer::where('name', 'テスト顧客')->first();
        $this->assertNotNull($readCustomer);

        $response = $this->actingAs($user)->get('/customers/' . $readCustomer->id);
        $response->assertStatus(200)->assertViewIs('customers.show')->assertSee('テスト顧客');

        $response = $this->actingAs($user)->get('/customers/1/edit');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->patch('/customers/' . $readCustomer->id, [
            'name' => 'テスト編集顧客',
            'ruby' => 'テストヘンシュウカスタマー',
            'gender_id' => '2',
            'birth' => '2000-01-01',
            'tel' => '0123456789',
            'address' => '千葉県千葉市千葉5000',
            'mail' => '',
            'job_id' => '4',
            'company' => ''
        ]);
        $response->assertRedirect('/customers/' . $readCustomer->id);

        $editedCustomer = \App\Customer::where('name', 'テスト編集顧客')->first();
        $this->assertNotNull($editedCustomer);

        // 進捗管理テスト
        $response = $this->actingAs($user)->get('/progresses');
        $response->assertStatus(200)->assertViewIs('progresses.index')->assertSee('進捗一覧');

        $response = $this->actingAs($user)->get('/progresses/create');
        $response->assertStatus(200)->assertViewIs('progresses.create')->assertSee('選んでください');

        $response = $this->actingAs($user)->get('/progresses/1/edit');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post('/progresses', [
            'user_id' => $user->id,
            'customer_id' => $editedCustomer->id,
            'status_id' => '1',
            'body' => '進捗のテスト中です！！',
            'created_at' => now(),
        ]);

        $readProgress = \App\Progress::where('body', '進捗のテスト中です！！')->first();
        $this->assertNotNull($readProgress);

        $response = $this->actingAs($user)->patch(
            '/progresses/' . $readProgress->id,
            [
                'user_id' => $user->id,
                'customer_id' => $editedCustomer->id,
                'status_id' => '5',
                'body' => '進捗の編集のテスト中です！！',
                'created_at' => now(),
            ]
        );
        $response->assertRedirect('/progresses');

        $editedProgress = \App\Progress::where('body', '進捗の編集のテスト中です！！')->first();
        $this->assertNotNull($editedProgress);

        $response = $this->actingAs($user)->delete('/progresses/' . $editedProgress->id);
        $response->assertRedirect('/progresses');

        $deletedProgress = \App\Progress::where('body', '進捗の編集のテスト中です！！')->first();
        $this->assertNull($deletedProgress);

        // 成約管理テスト
        $response = $this->actingAs($user)->get('/contracts');
        $response->assertStatus(200)->assertViewIs('contracts.index')->assertSee('成約一覧');

        $response = $this->actingAs($user)->get('/contracts/create');
        $response->assertStatus(200)->assertViewIs('contracts.create')->assertSee('選んでください');

        $response = $this->actingAs($user)->post('/contracts', [
            'customer_id' => $editedCustomer->id,
            'contract_type_id' => '9',
            'amount' => 4242424242,
            'due_date' => '2024-01-12',
            'created_at' => '2021-01-12 10:00:00',
        ]);
        $response->assertRedirect('/contracts');
        $readContract = \App\Contract::where('amount', '4242424242')->first();
        $this->assertNotNull($readContract);

        $response = $this->actingAs($user)->get('/contracts/'. $readContract->id .'/edit');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->patch('/contracts/' . $readContract->id, [
            'customer_id' => $editedCustomer->id,
            'contract_type_id' => '6',
            'amount' => 2424242424,
            'due_date' => '2024-01-12',
            'created_at' => '2021-01-12 10:00:00',
        ]);
        $response->assertRedirect('/contracts');
        $editedContract = \App\Contract::where('amount', '2424242424')->first();
        $this->assertNotNull($editedContract);

        $response = $this->actingAs($user)->delete('/contracts/' . $editedContract->id);
        $response->assertRedirect('/contracts');

        // 権限管理テスト
        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(200)->assertSee('権限一覧');

        $response = $this->actingAs($user)->get('/register');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test-user@user.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
        $readUser = \App\User::where('name', 'テストユーザー')->first();
        $this->assertNotNull($readUser);
        $this->assertTrue(\Hash::check('12345678', $readUser->password));

        $readUser->role = self::ADMIN;
        $readUser->save();
        $this->assertEquals(self::ADMIN, $readUser->role);

        $readUser->delete();

        // 存在しないルーティング
        $response = $this->actingAs($user)->get('/no_route');
        $response->assertStatus(404);

        // データ削除
        $editedCustomer->delete();
        $user->delete();
    }
}
