<?php

use App\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['Covid-19', 'Crypto Currency', 'Elections 2024', 'University', 'Travel', 'Hiking', 'Basket'];

        // Truncate() cancella tutte le righe della tabella e resetta l'indice autoincrementato.
        Tag::truncate();

        foreach($tags as $tag) {
            $newTag = new Tag();
            $newTag->name = $tag;
            $newTag->slug = Str::slug($tag);
            $newTag->save();
        }
    }
}
