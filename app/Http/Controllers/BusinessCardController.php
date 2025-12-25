<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessCardController extends Controller
{
    public function show($slug)
    {
        $card = \App\Models\BusinessCard::with('template')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Standardize data for view
        $content = $card->content ?? [];
        $services = $content['services'] ?? [];
        $experience = $content['experience'] ?? [];
        $stats = $content['stats'] ?? [];
        $quoteText = $content['quote_text'] ?? null;
        $quoteAuthor = $content['quote_author'] ?? $card->name;

        // Default to a fallback view if template is missing or deleted
        $view = $card->template ? $card->template->view_path : 'templates.business_default';

        return view($view, compact('card', 'content', 'services', 'experience', 'stats', 'quoteText', 'quoteAuthor'));
    }
}
