<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Role",
 *     @OA\Xml(
 *         name="Role"
 *     ),
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Role name"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         example="role_slug"
 *     ),
 * )
 */
class RoleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'is_visible' => $this->is_visible,
            'is_editable' => $this->is_editable,
        ];
    }
}
