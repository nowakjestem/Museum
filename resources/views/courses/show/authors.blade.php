<h1>Course</h1>
<ul>
    @foreach($course->authors as $author)
        <li>{{ $author->name }}</li>
    @endforeach
</ul>
