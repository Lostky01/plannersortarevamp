<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\DB;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('user')->orderBy('created_at', 'desc')->get();
        return view('welcome', compact('events'));
    }
    

    public function GetUserDetail($id) {
        $user = User::with('events')->findOrFail($id);
        return view('detailuser', compact('user'));
    }
    

    public function AddView() {
        return view('addmenu');
    }

    public function loginmenu() {
        return view('loginmenu');
    }


    public function store(Request $request) {
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
        $events->user_id = auth()->id();  // Assign user ID
        if ($request->hasFile('poster')) {
            $events->poster = $this->uploadImage($request->file('poster'));
        } else {
            $events->poster = 'default.jpg';  // Default poster
        }
        $events->save();
    
        return redirect()->route('index')->with('success', 'Event created successfully.');
    }

    public function uploadImage($imageFile) {
        $fileName = time() . '_' . $this->generateRandomString() . '.' . $imageFile->getClientOriginalExtension();
        $imageFile->move(public_path('poster-dummy'), $fileName);
    
        // Debugging: Pastikan file sudah ter-upload
        // if (file_exists(public_path('poster-dummy/' . $fileName))) {
        //     dd('File uploaded successfully: ' . $fileName);
        // } else {
        //     dd('File upload failed');
        // }
    
        return $fileName;
    }

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

    private function deleteImage($imageUrl)
    {
        if (!empty($imageUrl)) {
            $imagePath = public_path('image_info/' . $imageUrl);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }

    public function EditMenu($id) {
        $events = Event::findOrFail($id);
        return view('edit-event', compact('events'));
    }


    public function updateEvent(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' =>  'required',
            'date' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
         $events = Event::findOrFail($id);
         $events->title = $request->input('title');
         $events->description = $request->input('description');
         $events->location = $request->input('location');
         if($request->hasFile('poster')) {
            if($events->poster) {
                $this->deleteImage($events->poster);
            }
            $events->poster = $this->uploadImage($request->file('poster'));
         }
         $events->save();
         return redirect()->route('index')->with('Success');
    }


    public function DeleteEvent($id) {
        $events = Event::findOrFail($id);
        $this->deleteImage($events->poster);
        $events->delete();
        return redirect()->route('index')->with('success');
    }

    public function getEventById() {
    $events = Event::where('id', 'title')->first();
    return response()->json($events);

    }


}
