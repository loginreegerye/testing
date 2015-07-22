<h4>Hello, {{ $user->first_name.' '.$user->last_name }}!</h4>
<p>You owe this book in library:</p>
<p>{{ $book->author.' : '.$book->title.' ['.$book->genre.', '.$book->year.']' }}</p>