<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Item;
use App\Http\Filters\ItemFilter;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::filter(new ItemFilter());

        $items = $items->paginate();

        return ItemResource::collection($items);
    }

    public function show(Item $item)
    {
        return new ItemResource($item);
    }

    public function store(Request $request)
    {
        $validator = $this->validate(request(), Item::rules());

        $created = Item::create($validator);

        return new ItemResource($created);
    }

    public function update(Request $request, Item $item)
    {
        $validator = $this->validate(request(), Item::rules());

        $item->update($validator);

        return new ItemResource($item);
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return response([], 200);
    }
}
