<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryItemsController extends BaseController
{
    public function __construct()
    {
        $this->middleware('scope:admin')->except(['getAll', 'getOne']);
        $this->middleware(['auth:api'])->except(['getAll', 'getOne']);
    }

    public function getAll()
    {
        $articles = GalleryItem::all();
        return $this->sendResponse($articles, 'Articles récupérés avec succès');
    }

    public function getTotalNewsUploaded()
    {
        $totalNewsUploaded = GalleryItem::count();

        return $totalNewsUploaded;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Conseil,Finance',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif', 
        ]);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gallery_images', 'public'); 
            $data['image'] = $imagePath;
        }    

        $article = GalleryItem::create($data);
        if (!$article) {
            return $this->sendError('Une erreur s\'est produite lors de la création de l\'article');
        }
        return $this->sendResponse([], 'Article créé avec succès');
    }

    public function getOne($id)
    {
        // Retrieve the news article by ID
        $article = GalleryItem::findOrFail($id);

        // Retrieve the latest posts
        $latestPosts = GalleryItem::latest()->take(3)->get();
        $result = [
            'post' => $article,
            'similar' => $latestPosts
        ];
        return $this->sendResponse($result, 'Article récupéré avec succès');
    }

    public function update(Request $request, $id)
    {
        if ($request->hasFile('image')) {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|in:Conseil,Finance',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
            $imagePath = $request->file('image')->store('gallery_images', 'public');
            $data['image'] = $imagePath;
        }else{
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|in:Conseil,Finance',
                'image' => 'required|string',
            ]);
        }

        $item = GalleryItem::findOrFail($id);
        $updated = $item->update($data);

        if (!$updated) {
            return $this->sendError('Une erreur s\'est produite lors de la mise à jour de l\'article.');
        }
        return $this->sendResponse([], 'Article modifié avec succès');
    }

    public function destroy($id)
    {
        $article = GalleryItem::findOrFail($id);
        $deleted = $article->delete();

        if (!$deleted) {
            return $this->sendError('Une erreur s\'est produite lors de la suppression de l\'article.');
        }
        return $this->sendResponse([], 'Article supprimé avec succès');
    }
}
