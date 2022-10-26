<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;



class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_with_invalid_user_id()
    {
        /* Test if redirects to login page when the user_id set on session is invalid */
        $response = $this->withSession(["user_id"=>"1asdfasd","email"=>"fake@gmail.com"])->get('/');

        $response->assertLocation("/login");
        $response->assertStatus(302);
    }


    public function test_login_with_correct_user_id()
    {
        $testUserId = User::where("email","test@gmail.com")->get()->first()->id;
        $response = $this->withSession(["user_id"=>$testUserId])->get('/');
        // $response->dump();
        $response->assertStatus(200);
    }
}
