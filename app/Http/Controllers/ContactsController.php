<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactsCollection;
use App\Http\Resources\ContactsResource;
use App\Models\Contacts;
use App\Http\Requests\StoreContactsRequest;
use App\Http\Requests\UpdateContactsRequest;
use OpenApi\Attributes as OA;

#[OA\Parameter(name: 'notebook', description: 'Первичный ключ', in: 'path')]
class ContactsController extends Controller
{
    #[OA\Schema(
        schema: 'Contact',
        type: 'object',
        properties: [
            new OA\Property(property: 'full_name', type: 'string', description: 'Имя контакта'),
            new OA\Property(property: 'company', type: 'string', description: 'Компания контакта'),
            new OA\Property(property: 'phone', type: 'string', description: 'Телефон контакта'),
            new OA\Property(property: 'email', type: 'string', description: 'Email контакта'),
            new OA\Property(property: 'birth_date', type: 'string', format: 'date', description: 'Дата рождения контакта'),
            new OA\Property(property: 'photo_path', type: 'string', description: 'Путь к фото контакта'),
        ],
    )]
    
    #[OA\Get(
        description: 'Возвращает перечень всех контактов',
        path: '/api/v1/notebook/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Перечень контактов',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Контакт не найдена',
        response: 404,
    )]

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contacts::paginate(5); // Получение списка контактов с постраничной навигацией
        return new ContactsCollection($contacts);
    }

    #[OA\Post(
        description: 'Создает новый контакт',
        path: '/api/v1/notebook/',
        requestBody: new OA\RequestBody(
            description: 'Данные для создания нового контакта',
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/Contact'
            )
        )
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Контакт успешно создан',
        response: 201,
    )]
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactsRequest $request)
    {
        $data = $request->validated();
        $contact = Contacts::create($data);

        return response()->noContent(201)->withHeaders([
            'Location' => route('notebook.show', [
                'notebook' => $contact->id,
            ]),
        ]);
    }

    #[OA\Get(
        description: 'Возвращает контакт по идентификатору',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/notebook'),
        ],
        path: '/api/v1/notebook/{notebook}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Контакт',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Контакт не найдена',
        response: 404,
    )]

    /**
     * Display the specified resource.
     */
    public function show(Contacts $notebook)
    {
        return new ContactsResource($notebook);
    }

    #[OA\Patch(
        description: 'Обновляет контакт по идентификатору',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/notebook'),
        ],
        path: '/api/v1/notebook/{notebook}/',
        requestBody: new OA\RequestBody(
            description: 'Данные для обновления контакта',
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/Contact'
            )
        )
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Контакт успешно обновлен',
        response: 204,
    )]

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactsRequest $request, Contacts $notebook)
    {
        $data = $request->validated();
        // $notebook->update($data);
        $notebook->fill($data);
        $notebook->save();
        return response()->noContent(204);
    }

    #[OA\Delete(
        description: 'Удаляет контакт по идентификатору',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/notebook'),
        ],
        path: '/api/v1/notebook/{notebook}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Контакт успешно удален',
        response: 204,
    )]

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacts $notebook)
    {
        $notebook->delete();
        return response()->noContent(204);
    }
}
