<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageCollection;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string',
            'description' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ]);

        $order = $request->input('order', null);

        if (empty($order)) {
            $Image = Image::orderBy('order', 'desc')->first();

            if(isset($Image->order)){
                $order = $Image->order + 1 ?? 1;
            }else {
                $order = 1;
            }
        }

        $uploadedFile = $this->uploadImage($request->file('image'));
        $image = Image::create([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $order,
            'is_active' => $request->is_active,
            'file_path' => $uploadedFile['file_path'],
            'file_name' => $uploadedFile['file_name'],
        ]);

        return $this->successResponse(new ImageResource($image), 'Image uploaded');
    }


    public function index()
    {
        $images = Image::all();
        return $this->successResponse(new ImageCollection($images), 'Images');
    }

    public function update(Request $request, Image $image)
    {
        $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $updateData = [];

        if ($request->has('title')) {
            $updateData['title'] = $request->title;
        }

        if ($request->has('description')) {
            $updateData['description'] = $request->description;
        }

        if ($request->has('order')) {
            $updateData['order'] = $request->order;
        }

        if ($request->has('is_active')) {
            $updateData['is_active'] = $request->is_active;
        }

        if ($request->hasFile('image')) {
            $uploadedFile = $this->uploadImage($request->file('image'));
            $this->deleteImages($image->file_path, $image->file_name);

            $updateData['file_path'] = $uploadedFile['file_path'];
            $updateData['file_name'] = $uploadedFile['file_name'];
        }

        if (!empty($updateData)) {
            $image->update($updateData);
        }

        return response()->json([
            'message' => 'Image updated successfully',
            'data' => new ImageResource($image->fresh()) // Get fresh data from database
        ]);
    }

    public function ordering(Request $request)
    {
        $request->validate([
            'target_id' => 'required',
            'dragged_id' => 'required',
        ]);

        $target = Image::find($request->target_id);
        $dragged = Image::find($request->dragged_id);

        
        if (empty($target) || empty($dragged)) {
            return $this->errorResponse('Data not found', 404);
        }

        $draggerOrder = $dragged->order;
        $targetOrder = $target->order;
        $target->update(['order' => $draggerOrder]);
        $dragged->update(['order' => $targetOrder]);

        return $this->successResponse('Image order updated');
    }

    public function destroy(Image $image)
    {
        $this->deleteImages($image->file_path, $image->file_name);
        $image->delete();
        return $this->successResponse('Image deleted');
    }

    private function uploadImage(UploadedFile $file)
    {
        $path = $file->store('images', 'public');
        return [
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
        ];
    }

    private function deleteImages ($file_path, $file_name) {
        Storage::disk('public')->delete($file_path);
    }
}
