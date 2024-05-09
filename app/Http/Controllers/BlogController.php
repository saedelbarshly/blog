<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Imagable;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;


class BlogController extends Controller
{
    use ImageTrait;
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        try {
            $blog = Blog::create(['title' => $request->title]);
            if ($request->has('images')) {
                foreach ($request->images as $image) {
                    $photo = $this->upload_image($image, 'blog');
                    $blog->imagables()->create(['image' => $photo]);
                }
            }
            return response()->json(['message' => 'Blog added successfuly'], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Something went wrong!'], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {

        DB::beginTransaction();
        try {
            $blog->update(['title' => $request->title]);
            if ($request->has('images')) {
                foreach ($request->images as $image) {
                    $photo = $this->upload_image($image, 'blog');
                    $blog->imagables()->create(['image' => $photo]);
                }
            }
            if ($request->has('deleted_images')) {
                $deletedImagesIds = $request->deleted_images;
                $images = Imagable::whereIn('id', $deletedImagesIds)->get();
                foreach ($images as $image) {
                    $this->delete_image($image->image, 'blogs');
                    $image->delete();
                }
            }
            DB::commit();
            return response()->json(['message' => 'Blog updated successfully'], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong!'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        try {
            $blog->delete();
            return response()->json(['message' => 'Blog deleted successfuly'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Something went wrong!'], 400);
        }
    }
}
