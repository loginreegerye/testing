<h4>Hello, {{ $user->first_name.' '.$user->last_name }}!</h4>
<p>To library it is added the new book:</p>
<p>{{ $book->author.' : '.$book->title.' ['.$book->genre.', '.$book->year.']' }}</p>