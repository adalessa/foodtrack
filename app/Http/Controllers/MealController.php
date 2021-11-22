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
            'foods.*' => 'required|exists:foods,id',
            'type' => [
                'required',
                Rule::in(MealType::toValues()),
            ],
        ]);

        $meal = Meal::create([
            'user_id' => $request->user()->id,
            'date' => $validData['date'],
            'type' => MealType::from($validData['type']),
        ]);

        $meal->foods()->sync($validData['foods']);

        return response()
            ->redirectTo('/calendar')
            ->with('record', $meal->id);
    }

    public function edit(Meal $meal, Request $request)
    {
        return view('meals.edit', [
            'types' => MealType::cases(),
            'foods' => $request->user()->foods,
            'meal' => $meal,
        ]);
    }

    public function update(Meal $meal, Request $request)
    {
        $this->authorize('update', $meal);
        $validData = $request->validate([
            'foods.*' => 'required|exists:foods,id',
        ]);

        $meal->foods()->sync($validData['foods']);

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
