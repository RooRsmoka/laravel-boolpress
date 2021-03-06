<?php

namespace App\Traits;

use App\Post;
use Illuminate\Support\Str;

trait SlugGenerator {
    protected function generateUniqueSlug($postTitle) {
        // Genero lo slug partendo dal titolo
        $slug = Str::slug($postTitle);
    
        // controllo a db se esiste già un elemento con lo stesso slug
        $exists = Post::where("slug", $slug)->first();
        $counter = 1;
    
        // Fino a che $exists ha un valore diverso da null o false eseguo il while
        while ($exists) {
            // Genero un nuovo slug, prendendo quello precedente concatenato con il counter incrementato.
            $newSlug = $slug . "-" . $counter;
            $counter++;
    
            // controllo a db se esiste già un elemento con i nuovo slug appena generato
            $exists = Post::where("slug", $newSlug)->first();
    
            // Se non esiste, salvo il nuovo slug nella variabile $slug che verrà poi usata
            // per assegnare il valore all'interno del nuovo post.
            if (!$exists) {
                $slug = $newSlug;
            }
        }
    
        return $slug;
    }
}