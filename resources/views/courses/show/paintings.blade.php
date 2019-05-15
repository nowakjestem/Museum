<h1>Course</h1>
<ul>
    @foreach($course->paintings as $painting)
        <li>{{ $painting->name }}</li>
    @endforeach
</ul>
