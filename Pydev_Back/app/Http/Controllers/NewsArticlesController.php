<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Request;

class NewsArticlesController extends BaseController
{
    public function __construct()
    {
        $this->middleware('scope:user')->except(['getAll', 'getOne']);
        $this->middleware(['auth:api'])->except(['getAll', 'getOne']);
    }

    public function getAll()
    {
        $articles = NewsArticle::all();
        return $this->sendResponse($articles, 'Articles récupérés avec succès');
    }

    public function getTotalNewsUploaded()
    {
        $totalNewsUploaded = NewsArticle::count();

        return $totalNewsUploaded;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:1000',
            'content' => 'required|string',
            'location' => 'required|string',
            'resume' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
            $data['image'] = $imagePath;
        }

        $article = NewsArticle::create($data);
        if (!$article) {
            return $this->sendError('Une erreur s\'est produite lors de la création de l\'article');
        }
        return $this->sendResponse([], 'Article créé avec succès');
    }

    public function getOne($id)
    {
        // Retrieve the news article by ID
        $article = NewsArticle::findOrFail($id);

        // Retrieve the latest posts
        $latestPosts = NewsArticle::latest()->take(3)->get();
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
                'title' => 'required|string|max:1000',
                'content' => 'required|string',
                'location' => 'required|string',
                'resume' => 'required|string',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $imagePath = $request->file('image')->store('news_images', 'public');
            $data['image'] = $imagePath;
        } else {
            $data = $request->validate([
                'title' => 'required|string|max:1000',
                'content' => 'required|string',
                'location' => 'required|string',
                'resume' => 'required|string',
                'image' => 'required|string',
            ]);
        }
        
        $article = NewsArticle::findOrFail($id);
        $updated = $article->update($data);

        if (!$updated) {
            return $this->sendError('Une erreur s\'est produite lors de la mise à jour de l\'article.');
        }
        return $this->sendResponse([], 'Article modifié avec succès');
    }

    public function destroy($id)
    {
        $article = NewsArticle::findOrFail($id);
        $deleted = $article->delete();

        if (!$deleted) {
            return $this->sendError('Une erreur s\'est produite lors de la suppression de l\'article.');
        }
        return $this->sendResponse([], 'Article supprimé avec succès');
    }
}
