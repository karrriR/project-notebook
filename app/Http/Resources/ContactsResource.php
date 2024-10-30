<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'contacts',
            'id' => (string) $this->id,
            'attributes' => [
                'full_name' => $this->full_name,
                'company' => $this->company,
                'phone' => $this->phone,
                'email' => $this->email,
                'birth_date' => $this->birth_date instanceof \DateTimeInterface
                    ? $this->birth_date->format('Y-m-d')
                    : $this->birth_date,
                'photo_path' => $this->photo_path,
            ],
            'links' => [
                'self' => route('notebook.show', ['notebook' => $this->id]),
            ],
        ];
    }
}
