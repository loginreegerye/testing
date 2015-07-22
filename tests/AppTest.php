<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AppTest extends TestCase
{
	public function testHomePageLoad()
	{
		$this->visit('/');
	}

	public function testIsFollowsLinksOnHomePage()
	{
		$this->visit('/')
			 ->click('SIGN IN')
			 ->seePageIs('/auth/login');
		
		$this->visit('/')
			 ->click('SIGN UP')
			 ->seePageIs('/auth/register');
	}

	public function testAuthMiddlewarePartially()
	{
		$this->visit('/books')
			 ->seePageIs('/auth/login');

		$this->visit('/users')
			 ->seePageIs('/auth/login');

		$this->visit('/book')
			 ->seePageIs('/auth/login');

		$this->visit('/user')
			 ->seePageIs('/auth/login');
	}
}