<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            "ISBN" => $this->ISBN,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'publish_date' => $this->publish_date,

            // Task 9: free right now when nobody has an open borrowing of it
            'is_available' => !$this->customers()
                ->wherePivot('is_returned', false)
                ->exists(),

            'category' => CategoryResource::make(
                $this->whenLoaded('category')
            ),
        ];
    }
}