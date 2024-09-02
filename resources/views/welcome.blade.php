<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if (auth()->check())
    <a href="{{ route('addmenu') }}">Tambah data</a>
    <a href="{{ route('user-detail', auth()->user()->id) }}">Detail user</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>
    @endif
    @if(!auth()->check())
    <a href="{{ route('login-page') }}">Login</a>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Location</th>
                <th>Date</th>
                <th>Poster</th>
                <th>Added By</th> <!-- New Column -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach ($events as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->location }}</td>
                <td>{{ $item->date }}</td>
                <td><img src="{{ asset('poster-dummy/' . $item->poster) }}" alt="{{ $item->title }}" style="max-width: 150px; max-height: 150px;"></td>
                <td>{{ $item->user->name ?? 'N/A' }}</td> <!-- Display User Name -->
                <td>
                    @if(auth()->check() && auth()->id() === $item->user_id)
                    <a href="{{ route('edit-index', $item->id) }}">Edit</a>
                    <form action="{{ route('delete', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                    @else
                    <span>Not authorized</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
