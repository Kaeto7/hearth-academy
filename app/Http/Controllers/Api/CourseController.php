<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // GET /api/courses
    public function index(Request $request)
    {
        $query = Course::with(['deck', 'deckmaster']);

        // Фильтрация
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }
        if ($request->filled('deck_id')) {
            $query->where('deck_id', $request->deck_id);
        }

        // Сортировка
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);

        // Пагинация
        $perPage = min((int) $request->get('per_page', 15), 100);
        $courses = $query->paginate($perPage);

        return response()->json($courses);
    }

    // GET /api/courses/{id}
    public function show($id)
    {
        $course = Course::with(['deck', 'deckmaster', 'lessons', 'reviews'])->findOrFail($id);
        return response()->json($course);
    }

    // POST /api/courses
    public function store(Request $request)
    {
        $validated = $request->validate([
            'deckmaster_id' => 'required|exists:users,id',
            'deck_id' => 'required|exists:decks,id',
            'title' => 'required|string|max:255',
            'difficulty' => 'in:easy,medium,hard',
            'description' => 'nullable|string',
            'price' => 'numeric|min:0',
            'status' => 'in:draft,published,archived',
        ]);

        $course = Course::create($validated);
        return response()->json($course, 201);
    }

    // PUT /api/courses/{id}
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'difficulty' => 'sometimes|in:easy,medium,hard',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:draft,published,archived',
        ]);

        $course->update($validated);
        return response()->json($course);
    }

    // DELETE /api/courses/{id}
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete(); // soft delete
        return response()->json(['message' => 'Course deleted']);
    }

    // PATCH /api/courses/{id}/restore
    public function restore($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        $course->restore();
        return response()->json($course);
    }
}
