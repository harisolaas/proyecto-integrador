<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promotion;
// use Auth;

class PromotionController extends Controller
{

    public function validator()
    {
        $this->validate(request(), [
            'title' => 'required|string|max:25',
            'desc' => 'required|string|max:60',
            'banner' => 'required|file|max:200|image|mimes:jpeg,png,jpg'
        ]);
    }

    public function show($id)
    {
        $promotion = Promotion::find($id);
        return view('promotion', compact('promotion'));
    }

    public function store()
    {
        $this->validator();
        $promotion = Promotion::create([
            'title' => request()->input('title'),
            'desc' => request()->input('desc'),
            'seller_id' => request()->user()->id,
            'code' => rand(1000000000, 9999999999),
        ]);

        $path = 'public/img/promotions/'.request()->user()->id;
        $path = request()->file('banner')->store($path);

        $promotion->banner_path = str_ireplace("public", "/storage", $path);
        $promotion->update();
    }

    public function edit($id)
    {
        $promotions = request()->user()->promotions;
        $promotion = Promotion::findOrFail($id);
        return view('seller.promotion', compact('promotions','promotion'));
    }

    public function update($id)
    {
        $promotion = Promotion::findOrFail($id);

        $this->validator();

        $path = 'public/img/promotions/'.request()->user()->id;
        $path = request()->file('banner')->store($path);

        $promotion->banner_path = str_ireplace("public", "/storage", $path);

        $promotion->update([
            'title' => request()->input('title'),
            'desc' => request()->input('desc'),
            'seller_id' => request()->user()->id
        ]);
    }

    public function delete()
    {
        $promotion = Promotion::find(request()->input('promotion_id'));
        $promotion->delete();
    }

    public function toggle()
    {
        $promotion = Promotion::find(request()->input('promotion_id'));
        $promotion->active ? $promotion->active = 0 : $promotion->active = 1;
        $promotion->update();
    }
}
