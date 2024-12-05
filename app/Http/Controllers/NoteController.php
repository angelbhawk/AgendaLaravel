<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with('category', 'reminders', 'attachments')->get();
        return NoteResource::collection($notes);
    }

    public function store(NoteRequest $request)
    {
        $note = Note::create($request->validated());
        return new NoteResource($note);
    }

    public function show(Note $note)
    {
        $note->load('category', 'reminders', 'attachments');
        return new NoteResource($note);
    }

    public function update(NoteRequest $request, Note $note)
    {
        $note->update($request->validated());
        return new NoteResource($note);
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return response()->json(['message' => 'Note deleted successfully.']);
    }
}
