<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Detail</title>
</head>
<body>
    <h1>User Detail</h1>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    <h2>Events Created by {{ $user->name }}</h2>
    <ul>
        @forelse($user->events as $event)
            <li>
                <strong>Title:</strong> {{ $event->title }} <br>
                <strong>Description:</strong> {{ $event->description }} <br>
                <strong>Date:</strong> {{ $event->date }} <br>
                <strong>Location:</strong> {{ $event->location }}
            </li>
        @empty
            <p>No events created by this user.</p>
        @endforelse
    </ul>
</body>
</html>
