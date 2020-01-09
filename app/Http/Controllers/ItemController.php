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
        $input = $request->all();

        $created = Item::create($input);

        return new ItemResource($created);
    }

    public function update(Request $request, Item $item)
    {
        $input = $request->all();

        $item->update($input);

        return new ItemResource($item);
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return response([], 200);
    }
}
