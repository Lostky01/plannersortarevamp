<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventControllerApi extends Controller
{
    // Get all events
    public function index()
    {
        
        $events = Event::orderBy('created_at', 'desc')->get();
        return response()->json($events);
    }

    // Store new event
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'date' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,gif',
        ]);

        $events = new Event();
        $events->title = $request->title;
        $events->description = $request->description;
        $events->location = $request->location;
        $events->date = $request->date;

        if ($request->hasFile('poster')) {
            $events->poster = $this->uploadImage($request->file('poster'));
        }

        $events->save();

        return response()->json([
            'success' => true,
            'message' => 'Event created successfully',
            'data' => $events
        ], 201); // HTTP 201 Created
    }

    // Update existing event
    public function updateEvent(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'date' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
    
        $events = Event::findOrFail($id);
        $events->title = $request->input('title');
        $events->description = $request->input('description');
        $events->location = $request->input('location');
        $events->date = $request->input('date');
    
        // Debugging output
        // dd($request->all());
    
        if ($request->hasFile('poster')) {
            if ($events->poster) {
                $this->deleteImage($events->poster);
            }
            $events->poster = $this->uploadImage($request->file('poster'));
        }
    
        $events->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully',
            'data' => $events
        ]);
    }
    

    // Delete event by ID
    public function DeleteEvent($id)
    {
        $events = Event::findOrFail($id);
        $this->deleteImage($events->poster);
        $events->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully'
        ]);
    }

    // Get event by ID
    public function getEventById($id)
    {
        $events = Event::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    // Upload image (helper function)
    public function uploadImage($imageFile)
    {
        $fileName = time() . '_' . $this->generateRandomString() . '.' . $imageFile->getClientOriginalExtension();
        $imageFile->move(public_path('poster-dummy'), $fileName);

        return $fileName;
    }

    // Generate random string (helper function)
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    // Delete image by filename (helper function)
    private function deleteImage($imageUrl)
    {
        if (!empty($imageUrl)) {
            $imagePath = public_path('poster-dummy/' . $imageUrl);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }
}
