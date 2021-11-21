<?php

namespace App\Http\Controllers;

use App\Enums\MealType;
use App\Models\Food;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MealController extends Controller
{
    public function index()
    {
        return view('meals.index');
    }

    public function create(Request $request)
    {
        return view('meals.create', [
            'types' => MealType::cases(),
            'foods' => $request->user()->foods,
        ]);
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'date' => 'required',
            'food_id' => 'required|exists:foods,id',
            'type' => [
                'required',
                Rule::in(MealType::toValues()),
            ],
        ]);

        $food = Food::find($validData['food_id']);
        $this->authorize('view', $food);

        $meal = Meal::create([
            'user_id' => $request->user()->id,
            'food_id' => $food->id,
            'date' => $validData['date'],
            'type' => MealType::from($validData['type']),
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
