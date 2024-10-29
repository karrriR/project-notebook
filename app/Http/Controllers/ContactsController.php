<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactsCollection;
use App\Http\Resources\ContactsResource;
use App\Models\Contacts;
use App\Http\Requests\StoreContactsRequest;
use App\Http\Requests\UpdateContactsRequest;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contacts::paginate(10); // Получение списка контактов с постраничной навигацией
        return new ContactsCollection($contacts); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactsRequest $request)
    {
        $data = $request->validated();
        $contact = Contacts::create($data);

        return response()->noContent(201)->withHeaders([
            'Location' => route('contacts.show', [
                'contact' => $contact->id,
            ]),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contacts $contacts)
    {
        return new ContactsResource($contacts);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactsRequest $request, Contacts $contacts)
    {
        $data = $request->validated();
        $contacts->update($data);
        return response()->noContent(204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacts $contacts)
    {
        $contacts->delete();
        return response()->noContent(204);
    }
}
