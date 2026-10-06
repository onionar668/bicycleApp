<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bicycles;
use App\Models\Tariffs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BicyclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bicycles = Bicycles::all();

        return response()->json([
            'data' => $bicycles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bicycle = Bicycles::where('id', $id)->first();

        if (!$bicycle) {
            return response()->json([
                'message' => "Bicycle with id: $id not found"
            ], 404);
        }
        return response()->json([
            'message' => $bicycle
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function tariffBicycle(Request $request, string $id)
    {
        $bicycle = Bicycles::findOrFail($id);

        $tariffs = $bicycle->tariff;

        return response()->json([
            'tariff' => $tariffs
        ], 200);
    }

    public function priceBicycle(Request $request, string $bicycleId, string $tariffId)
    {
        $bicycle = Bicycles::findOrFail($bicycleId);
        $tariff = Tariffs::where('id', $tariffId)->where('category_id', $bicycle->category_id)->firstOrFail();
        if ($tariff->type === 'STATIC') {
            return $tariff->base_price;
        }

        $response = Http::get('http://localhost:6868/data');

        if ($response->failed()) {
            return response()->json(['message' => 'Service not found'], 503);
        }

        $data = $response->json();

        $trafficNumberScale = $data['number_scale'];
        $colorName = $data['color_scale_of_corks'];

        $colorMultipliers = [
            'green'  => 0.9,
            'yellow' => 1,
            'red'  =>   1.2,
            'black' =>  1.5
        ];

        $colorMultipier = $colorMultipliers[$colorName] ?? 1.0;

        $dynamic_price = $tariff->base_price * (1 + $trafficNumberScale / 100) * $colorMultipier;

        if ($tariff->min_price !== null &&  $dynamic_price < $tariff->min_price) {
            $dynamic_price = $tariff->min_price;
        }
        if ($tariff->max_price !== null &&  $dynamic_price > $tariff->max_price) {
            $dynamic_price = $tariff->max_price;
        }
        return response()->json([
            'price' => round($dynamic_price)
        ], 200);
    }

    public function rentalsBicycle(Request $request, string $id)
    {
        $bicycle = Bicycles::findOrFail($id);
        $rent = $bicycle->booking;

        return response()->json([
            'data' => $rent
        ],200);
    }
}
