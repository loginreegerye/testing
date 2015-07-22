<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Book;

class BookControllerTest extends TestCase
{

	use WithoutMiddleware;

	use DatabaseTransactions;

	public function testIsReturnedBooksDataToView()
	{
		$this->action('GET', 'BookController@getAllPaginate');
		
		$this->assertViewHas('books');
	}

	public function testIsReturnedViewAllBooks()
	{
		$this->visit('/books')
			 ->see('ALL BOOKS');
	}

/*	public function testIsReturnedViewAllBooks()  //method analog to the previous
	{
		$this->makeRequest('GET', '/books');

		$this->assertCount(1, $this->crawler->filter("title:contains('ALL BOOKS')"));
	}*/

	public function testIsReturnedPaginatorData()
	{
		$response = $this->action('GET', 'BookController@getAllPaginate');

		$view = $response->getOriginalContent();

		$this->assertGreaterThan(0, count($view['books']));
	}

	public function testIsInstanceOfPaginatorReturnedData()
	{
		$response = $this->action('GET', 'BookController@getAllPaginate');

		$view = $response->getOriginalContent();

		$this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $view['books']);
	}

	public function testIsReturnedPaginatorTenBooksPerPage()
	{
		$response = $this->action('GET', 'BookController@getAllPaginate');

		$view = $response->getOriginalContent();

		$this->assertCount(10, $view['books']);
	}

	public function testIsRedirectInIndexResourceMethod()
	{
		$this->call('GET', '/book');
		
		$this->assertResponseStatus(302);
	}

	public function testBookIsAddedEvent()
	{
		$book = new Book;
		$book->title = 'BOOKTITLE';
		$book->author = 'BOOKAUTHOR';
		$book->year = 2015;
		$book->genre = 'BOOKGENRE';

		$this->expectsEvents(App\Events\BookIsAdded::class);

		$this->call('POST', '/book', $book->toArray());
	}

	public function testSessionHasMessage()
	{
		$book = new Book;
		$book->title = 'BOOKTITLE';
		$book->author = 'BOOKAUTHOR';
		$book->year = 2015;
		$book->genre = 'BOOKGENRE';

		$this->call('POST', '/book', $book->toArray());

		$this->assertSessionHas('message', 'SUCCESSFYLLY CREATED');
	}

	public function testHasRedirectToNewBookPage()
	{
		$book = new Book;
		$book->title = 'BOOKTITLE';
		$book->author = 'BOOKAUTHOR';
		$book->year = 2015;
		$book->genre = 'BOOKGENRE';

		$this->call('POST', '/book', $book->toArray());

		$book_from_db = Book::latest()->take(1)->get();

		$book_from_db->toArray();

		$this->assertRedirectedTo('/book/'.$book_from_db[0]['id']);
	}

	public function testValidationForCreatingUserAndRedirect()
	{
		$book = new Book;
		$book->title = 'BOOKTITLE';
		$book->author = 'BOOKAUTHOR';
		$book->genre = 'BOOKGENRE';

		$this->call('POST', '/book', $book->toArray());

		$this->assertSessionHas('errors');

		$this->assertHasOldInput();

		$this->assertRedirectedTo('/book/create');
	}

	public function testIsBookDeletWorkAndRedirect()
	{
		$book = new Book;
		$book->title = 'DELETEBOOKTITLE';
		$book->author = 'DELETEBOOKAUTHOR';
		$book->year = 1000;
		$book->genre = 'DELETEBOOKGENRE';
		$book->save();

		$book->toArray();

		$response = $this->call('DELETE', '/book/'.$book['id']);

		$this->assertSessionHas('message', 'BOOK SUCCESSFYLLY DELETED, BUT YOU CAN CREATE THE NEW BOOK BY USING THIS FORM');

		$this->assertRedirectedTo('/book/create');
	}

	public function testIsCantDeletBookWhenHasUser()
	{
		$book = new Book;
		$book->user_id = 1;
		$book->title = 'DELETEBOOKTITLE';
		$book->author = 'DELETEBOOKAUTHOR';
		$book->year = 1000;
		$book->genre = 'DELETEBOOKGENRE';
		$book->save();

		$book->toArray();

		$response = $this->call('DELETE', '/book/'.$book['id']);

		$this->assertSessionHas('message', 'CAN\'T DELETE, BOOK HAS USER');

		$this->assertRedirectedTo('/book/'.$book['id']);
	}

	public function testIsCorrectShowEmptyDataAboutBook()
	{
		$book = new Book;
		$book->title = 'SHOWBOOKTITLE';
		$book->author = 'SHOWBOOKAUTHOR';
		$book->year = 1000;
		$book->genre = 'SHOWBOOKGENRE';
		$book->save();

		$this->call('GET', '/book/'.$book->id);

		$this->assertViewHas('book');

		$this->assertViewHas('empty', 'THIS BOOK HAS NO USER');
	}

	public function testIsCorrectShowNotEmptyDataAboutBook()
	{
		$book = new Book;
		$book->user_id = 1;
		$book->title = 'SHOWBOOKTITLE';
		$book->author = 'SHOWBOOKAUTHOR';
		$book->year = 1000;
		$book->genre = 'SHOWBOOKGENRE';
		$book->save();

		$this->call('GET', '/book/'.$book->id);

		$this->assertViewHas('book');

		$this->assertViewHas('user');
	}

	public function testValidateEditData()
	{
		$book = new Book;
		$book->title = 'EDITEBOOKTITLE';
		$book->author = 'EDITBOOKAUTHOR';
		$book->year = 1000;
		$book->genre = 'EDITBOOKGENRE';
		$book->save();

		$book->toArray();

		$response = $this->call('PUT', '/book/'.$book['id'], $book->toArray());

		$this->assertSessionHas('message', 'SUCCESSFYLLY UPDATED');

		$this->assertRedirectedTo('/book/'.$book['id']);
	}

	public function testValidateDataIsWorkedEchoErrorRequiredField()
	{
		$book = new Book;
		$book->title = 'EDITEBOOKTITLE';
		$book->author = 'EDITBOOKAUTHOR';
		$book->genre = 'EDITBOOKGENRE';
		$book->save();

		//dd(gettype($book->year));

		$book->toArray();

		$response = $this->call('PUT', '/book/'.$book['id'], $book->toArray());

		$this->assertSessionHas('errors');

		$this->assertRedirectedTo('/book/'.$book['id'].'/edit');
	}

/*	public function testValidateDataIsWorkedTestFailed()
	{
		$book = new Book;
		$book->title = 'EDITEBOOKTITLE';
		$book->author = 'EDITBOOKAUTHOR';
		$book->year = '1000';                     // this is string, no integer. Test failed. Why?! Must be passed!
		$book->genre = 'EDITBOOKGENRE';
		$book->save();

		//dd(gettype($book->year));

		$book->toArray();

		$response = $this->call('PUT', '/book/'.$book['id'], $book->toArray());

		$this->assertSessionHas('errors');

		$this->assertRedirectedTo('/book/'.$book['id'].'/edit');
	}*/

	public function testIsReturnedAboutAvailableBooksData()
	{
		$this->action('GET', 'BookController@getAvailableToAdd');

		$this->assertViewHas('books');
	}

	public function testIsWorkedFirstRelationMethod($user_id = 1)
	{
		$book = new Book;
		$book->title = 'TITLE';
		$book->author = 'AUTHOR';
		$book->year = 2015;
		$book->genre = 'GENRE';
		$book->save();

		$book->toArray();
		
		$this->call('PUT', '/user/'.$user_id.'/add/'.$book['id']);

		$this->assertSessionHas('message', 'BOOK SUCCESSFYLLY ADDED TO USER');

		$this->assertRedirectedTo('/user/'.$user_id);
	}

	public function testIsWorkedSecondRelationMethod($user_id = 1)
	{
		$book = new Book;
		$book->title = 'TITLE';
		$book->author = 'AUTHOR';
		$book->year = 2015;
		$book->genre = 'GENRE';
		$book->save();

		$book->toArray();
		
		$this->call('PUT', '/book/'.$book['id'].'/add/'.$user_id);

		$this->assertSessionHas('message', 'USER SUCCESSFYLLY ADDED FOR BOOK');

		$this->assertRedirectedTo('/book/'.$book['id']);
	}

	public function testName($user_id = 1)
	{
		$book = new Book;
		$book->user_id = 1;
		$book->title = 'TITLE';
		$book->author = 'AUTHOR';
		$book->year = 2015;
		$book->genre = 'GENRE';
		$book->save();

		$book->toArray();

		$this->call('DELETE', '/user/'.$user_id.'/del/'.$book['id']);

		$this->assertSessionHas('message', 'BOOK DELETE FROM USER');

		$this->assertRedirectedTo('/user/'.$user_id);
	}

	public function testName_($user_id = 1)
	{
		$book = new Book;
		$book->user_id = 1;
		$book->title = 'TITLE';
		$book->author = 'AUTHOR';
		$book->year = 2015;
		$book->genre = 'GENRE';
		$book->save();

		$book->toArray();

		$this->call('DELETE', '/book/'.$book['id'].'/del/'.$user_id);

		$this->assertSessionHas('message', 'USER OF THIS BOOK WAS REMOVED');

		$this->assertRedirectedTo('/book/'.$book['id']);
	}

	///////////////////////////////////////////////////////////////////////////
	//FAILED
	///////////////////////////////////////////////////////////////////////////

	//*************************************************************************
	// A request failed. Recived status code 500.
	//
	// Problem: 1. Undefined variables in returned views: $errors.
	//
	//			2. Runtime Exception with message:
	//				'Session store no set on request' on Session:: and Input::
	//
	//*************************************************************************

	//*************************************************************************
	//
	// Solution: maybe trying isset() function
	//
	//*************************************************************************
	
	public function testIsReturnedViewBookCreate()
	{
		$this->visit('/book/create')
			 ->see('CREATE BOOK');
	}

	public function testIsReturnedViewBookEdit($id = 1)
	{
		$this->visit('/book/'.$id.'/edit');

		$this->assertViewHas('book');
	}
	
	///////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////
}