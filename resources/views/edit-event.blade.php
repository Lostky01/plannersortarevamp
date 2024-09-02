<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{route('edit', $events->id)}}" method="POST">
        @csrf
        @method('PUT')
        <label for="title">Title</label>
        <input type="text" placeholder="title" name="title" id="title" value="{{$events->title}}">
        <label for="description">Description</label>
        <input type="text" placeholder="description" name="description" id="description" value="{{$events->description}}">
        <label for="location">Location</label>
        <input type="text" placeholder="location" name="location" id="location" value="{{$events->location}}">
        <label for="date">Date</label>
        <input type="date" name="tanggal" id="tanggal" value="{{$events->date}}">
        <label for="poster">Poster</label>
        <input type="file" name="poster" id="poster" value="{{$events->poster}}">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
