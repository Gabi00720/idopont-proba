<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user_id,
                'name' => $this->user->name,
            ],
            'license_plates' => $this->license_plates,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'location' => $this->location,
            'people' => $this->people,
            'status' => $this->status,
            'comment' => $this->comment,
            'document_path' => $this->document_path,
            'created_at' => $this->created_at,
        ];
    }
}
