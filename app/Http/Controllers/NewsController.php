<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = News::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($data) {
                    return $data->category->name;
                })
                ->addColumn('action', function ($data) {
                    $actionBtn = '<a href="/dashboard/news/detail-' .  $data->title . '" class="info btn btn-info btn-sm"><i class="fa-solid fa-circle-info" style="color: #ffffff;"></i></a> <a href="/dashboard/news/edit-' .  $data->title . '" class="edit btn btn-secondary btn-sm"><i class="fas fa-pen"></i></a> <a class="delete btn btn-danger btn-sm" onclick="deleteConfirmation(' . $data->id . ')"><i class="fas fa-trash" style="color: white;"></i></a>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('news.all');
    }

    public function all()
    {
        $news = News::all();
        if ($news->isEmpty()) {
            return $this->notFoundResponse(null);
        }
        return $this->getSuccessResponse($news);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category_product = Category::all();
        return view('news.create', ['category_product' => $category_product]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'category_id' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'author' => 'required',
            ]);

            //$imageName = null;
            if ($request->hasFile('thumbnail')) {
                $img = $request->file('thumbnail');
                $imageName = Str::random(5) . '-' . $img->getClientOriginalName();
                $img->move(public_path('/assets/news'), $imageName);
            }

            News::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'thumbnail' => $imageName,
                'author' => $request->author,
                'created_at' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
            ]);

            return redirect()->route('news.all')->with('success', 'News Berhasil Dibuat!');
        } catch (\Throwable $th) {
            return redirect()->route('news.all')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        if ($request->wantsJson()) {
            $news = News::where('title', $id)->first();
            if (!$news) {
                return $this->notFoundResponse(null);
            }
            return $this->getSuccessResponse($news);
        }

        $news = News::where('title', $id)->first();
        return view('news.detail', ['news' => $news]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category_product = Category::all();
        $news = News::where('title', $id)->first();
        return view('news.edit', ['news' => $news, 'category_product' => $category_product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $rules = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'category_id' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'author' => 'required',
            ]);
            $news = News::where('title', $id)->first();
            $oldImageName = $news->thumbnail;

            if ($request->hasFile('thumbnail')) {
                if ($oldImageName) {
                    $oldImagePath = public_path('/assets/news') . '/' . $oldImageName;
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }
                $img = $request->file('thumbnail');
                $imageName = Str::random(5) . '-' . $img->getClientOriginalName();
                $img->move(public_path('/assets/news'), $imageName);
            } else {
                $imageName = $oldImageName;
            }

            $news->update([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'thumbnail' => $imageName,
                'author' => $request->author,
                'update_at' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
            ]);

            return redirect()->route('news.all')->with('success', 'News Berhasil Diupdate!');
        } catch (\Throwable $th) {
            return redirect()->route('news.all')->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $news = News::find($id);
            $oldImageName = $news->thumbnail;

            if ($oldImageName) {
                $oldImagePath = public_path('/assets/news') . '/' . $oldImageName;
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $news->delete();

            return redirect()->route('news.all')->with('success', 'News Berhasil Dihapus!');
        } catch (\Throwable $th) {
            return redirect()->route('news.all')->with('error', $th->getMessage());
        }

    }
}
