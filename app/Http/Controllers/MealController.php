<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function store(Request $request)
    {
        $validData = $request->validate([
            'date' => 'required',
            'food_id' => 'required|exists:foods,id',
            'type' => 'required',
        ]);

        $food = Food::find($validData['food_id']);
        $this->authorize('view', $food);

        $meal = Meal::create([
            'user_id' => $request->user()->id,
            'food_id' => $food->id,
            'date' => $validData['date'],
            'type' => $validData['type'],
        ]);

        return response()
            ->redirectTo('/calendar')
            ->with('record', $meal->id);
    }

    public function update(Meal $meal, Request $request)
    {
        $this->authorize('update', $meal);
        $validData = $request->validate([
            'food_id' => 'required|exists:foods,id',
        ]);

        $food = Food::find($validData['food_id']);
        $this->authorize('view', $food);

        $meal->food_id = $food->id;
        $meal->save();

        return response()
            ->redirectTo('/calendar')
            ->with('record', $meal->id);
    }

    public function destroy(Meal $meal)
    {
        $this->authorize('delete', $meal);
        $meal->delete();

        return response()
            ->redirectTo('/calendar');
    }
}
