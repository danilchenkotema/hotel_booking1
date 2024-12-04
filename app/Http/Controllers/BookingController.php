<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // 1. Создать новую бронь
    public function store(Request $request)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date',
            'status' => 'in:confirmed,unconfirmed',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $booking = Booking::create($validated);
        return response()->json($booking, 201);
    }

    // 2. Отобразить список броней (с пагинацией и фильтрацией)
    public function index(Request $request)
    {
        $status = $request->query('status');
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);

        $query = Booking::query();
        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->limit($limit)->offset($offset)->get();
        return response()->json($bookings);
    }

    // 3. Удалить бронь
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully'], 200);
    }

    // 4. Отредактировать бронь
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'check_in_date' => 'sometimes|date',
            'status' => 'sometimes|in:confirmed,unconfirmed',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $booking->update($validated);
        return response()->json($booking);
    }

    // 5. Получить бронь по ID
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return response()->json($booking);
    }

    // 6. Получить список броней конкретного пользователя
    public function getByUser($userId, Request $request)
    {
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);

        $bookings = Booking::where('user_id', $userId)
            ->limit($limit)
            ->offset($offset)
            ->get();

        return response()->json($bookings);
    }
}
