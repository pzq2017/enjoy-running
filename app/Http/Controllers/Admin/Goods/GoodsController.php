<?php

namespace App\Http\Controllers\Admin\Goods;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Good;
use App\Models\GoodsCategory;
use Illuminate\Http\Request;

class GoodsController extends AdminController
{
    public function index(Request $request)
    {
        return view('admin.goods.index');
    }

    public function lists(Request $request)
    {
        $query = Good::when($request->name, function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->name.'%');
        })
        ->when($request->category_id, function ($query) use ($request) {
            $query->where('category_id', $request->category_id);
        });

        $count = $query->count();
        $lists = $this->pagination($query, $request);

        return $this->handleSuccess(['total' => $count, 'lists' => $lists]);
    }

    public function create()
    {
        $categories = GoodsCategory::where('status', 1)->get();

        return view('admin.goods.create', compact('categories'));
    }

    public function store()
    {

    }

    public function edit()
    {
        return view('admin.goods.edit');
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
