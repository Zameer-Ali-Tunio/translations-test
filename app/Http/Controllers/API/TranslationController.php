<?php

namespace App\Http\Controllers\API;

use App\Models\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Translations",
 *     description="API Endpoints for Managing Translations"
 * )
 */
class TranslationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/translations",
     *     summary="List all translations",
     *     tags={"Translations"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="Accept header",
     *         required=true,
     *         @OA\Schema(type="string", default="application/json")
     *     ),
     *     @OA\Parameter(
     *         name="key",
     *         in="query",
     *         description="Filter by translation key",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="tag",
     *         in="query",
     *         description="Filter by tag",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="content",
     *         in="query",
     *         description="Filter by translation content",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Translation::query();

        if ($request->filled('key')) {
            $query->where('key', 'like', "%{$request->key}%");
        }

        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        if ($request->filled('content')) {
            $query->where('translations->en', 'like', "%{$request->content}%")
                  ->orWhere('translations->fr', 'like', "%{$request->content}%")
                  ->orWhere('translations->es', 'like', "%{$request->content}%");
        }

        return response()->json($query->get());
    }

    /**
     * @OA\Post(
     *     path="/api/translations",
     *     summary="Create a new translation",
     *     tags={"Translations"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="Accept header",
     *         required=true,
     *         @OA\Schema(type="string", default="application/json")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"key", "translations"},
     *             @OA\Property(property="key", type="string"),
     *             @OA\Property(property="translations", type="object", example={"en": "Hello", "fr": "Bonjour"}),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Translation created"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:translations,key',
            'translations' => 'required|array',
            'tags' => 'nullable|array'
        ]);

        $translation = auth()->user()->translations()->create($validated);

        return response()->json($translation, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/translations/{id}",
     *     summary="Get a specific translation",
     *     tags={"Translations"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="Accept header",
     *         required=true,
     *         @OA\Schema(type="string", default="application/json")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Translation details"
     *     )
     * )
     */
    public function show(Translation $translation)
    {
        return $translation;
    }

    /**
     * @OA\Put(
     *     path="/api/translations/{id}",
     *     summary="Update a translation",
     *     tags={"Translations"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="Accept header",
     *         required=true,
     *         @OA\Schema(type="string", default="application/json")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="translations", type="object", example={"en": "Updated"}),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Translation updated"
     *     )
     * )
     */
    public function update(Request $request, Translation $translation)
    {
        $validated = $request->validate([
            'translations' => 'sometimes|array',
            'tags' => 'sometimes|array'
        ]);

        $translation->update($validated);

        return $translation;
    }

    /**
     * @OA\Delete(
     *     path="/api/translations/{id}",
     *     summary="Delete a translation",
     *     tags={"Translations"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="Accept header",
     *         required=true,
     *         @OA\Schema(type="string", default="application/json")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Translation deleted"
     *     )
     * )
     */
    public function destroy(Translation $translation)
    {
        $translation->delete();
        return response()->json(true, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/translations/export",
     *     summary="Export translations for frontend",
     *     tags={"Translations"},
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="Accept header",
     *         required=true,
     *         @OA\Schema(type="string", default="application/json")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="JSON map of all translations"
     *     )
     * )
     */
    public function export()
    {
        return response()->json(
            Translation::all()->pluck('translations', 'key')
        );
    }
}
