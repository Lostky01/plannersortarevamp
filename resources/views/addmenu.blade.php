<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('store-event') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="title">Title</label>
        <input type="text" placeholder="title" name="title" id="title" value="{{old('title')}}">

        <label for="description">Description</label>
        <input type="text" placeholder="description" name="description" id="description" {{old('description')}}>

        <label for="location">Location</label>
        <input type="text" placeholder="location" name="location" id="location" value="{{old('location')}}">

        <label for="date">Date</label>
        <input type="date" name="date" id="date" value="{{old('date')}}">

        <label for="poster">Poster</label>
        <input type="file" name="poster" id="poster" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="">

        <button type="submit">Submit</button>
    </form>
</body>
</html>