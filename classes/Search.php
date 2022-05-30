<?php

require_once 'Anime.php';
require_once 'Manga.php';
require_once 'Category.php';
require_once 'Episode.php';

class Search {

    private $base_url = "https://kitsu.io/api/edge";


    private function setCurl($p) {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $p);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        $list = json_decode($response);
        
        return $list;
    }

    private function setAnimes($list) {

        $array = [];
        
        error_reporting(E_ALL ^ E_WARNING);

        foreach ($list->data as $item ) {
            $i = new Anime();
            $i->setId($item->id);
            $i->setType($item->type);
            $i->setSelfLink($item->links->self);
            $i->setCanonicalTitle($item->attributes->canonicalTitle);
            $i->setSynopsis($item->attributes->synopsis);
            $i->setAverageRating($item->attributes->averageRating);
            $i->setFavoritesCount($item->attributes->favoritesCount);
            $i->setStartDate($item->attributes->startDate);
            $i->setEndDate($item->attributes->endDate);
            $i->setPopularityRank($item->attributes->popularityRank);
            $i->setRatingRank($item->attributes->ratingRank);
            $i->setAgeRatingGuide($item->attributes->ageRatingGuide);
            $i->setStatus($item->attributes->status);
            $i->setPosterImage($item->attributes->posterImage->original);
            $i->setCoverImage($item->attributes->coverImage->original);
            $i->setEpisodeCount($item->attributes->episodeCount);
            $i->setGenres($item->relationships->genres->links->related);
            $i->setCategories($item->relationships->categories->links->related);
            $i->setEpisodes($item->relationships->episodes->links->self);
            
            $array[] = $i;
        }

        error_reporting(E_ALL);

        return $array;
    }

    private function setManga($list) {

        $array = [];

        error_reporting(E_ALL ^ E_WARNING);

        foreach ($list->data as $item ) {
            $i = new Manga();
            $i->setId($item->id);
            $i->setType($item->type);
            $i->setSelfLink($item->links->self);
            $i->setCanonicalTitle($item->attributes->canonicalTitle);
            $i->setSynopsis($item->attributes->synopsis);
            $i->setAverageRating($item->attributes->averageRating);
            $i->setFavoritesCount($item->attributes->favoritesCount);
            $i->setStartDate($item->attributes->startDate);
            $i->setEndDate($item->attributes->endDate);
            $i->setPopularityRank($item->attributes->popularityRank);
            $i->setRatingRank($item->attributes->ratingRank);
            $i->setAgeRatingGuide($item->attributes->ageRatingGuide);
            $i->setSerialization($item->attributes->serialization);
            $i->setMangaType($item->attributes->mangaType);
            $i->setStatus($item->attributes->status);
            $i->setPosterImage($item->attributes->posterImage->small);
            $i->setChapterCount($item->attributes->chapterCount);
            $i->setGenres($item->relationships->genres->links->related);
            $i->setCategories($item->relationships->categories->links->related);
            $i->setChapters($item->relationships->chapters->links->self);
            
            $array[] = $i;
        }

        error_reporting(E_ALL);

        return $array;
    }

    public function animeFilter($us) {

        $s = preg_replace('/[ -]+/' , '%20' , $us);

        $url = "/anime?filter%5Btext%5D=".$s;

        $list = $this->setCurl($this->base_url.$url);

        $animes = $this->setAnimes($list);

        return $animes; 
    }

    public function mangaFilter($us) {

        $s = preg_replace('/[ -]+/' , '%20' , $us);

        $url = "/manga?filter%5Btext%5D=".$s;

        $list = $this->setCurl($this->base_url.$url);

        $mangas = $this->setManga($list);

        return $mangas; 
    }

    public function trendingAnime() {

        $list = $this->setCurl($this->base_url."/trending/anime");

        $animes = $this->setAnimes($list);

        return $animes; 
    }

    public function trendingManga() {

        $list = $this->setCurl($this->base_url."/trending/manga");
        
        $mangas = $this->setManga($list);

        return $mangas;
    }

    public function animeId($id) {
        
        $anime = $this->setCurl($this->base_url."/anime/$id");

        error_reporting(E_ALL ^ E_WARNING);

        $a = new Anime();
        $a->setId($anime->data->id);
        $a->setType($anime->data->type);
        $a->setSelfLink($anime->data->links->self);
        $a->setCanonicalTitle($anime->data->attributes->canonicalTitle);
        $a->setSynopsis($anime->data->attributes->synopsis);
        $a->setAverageRating($anime->data->attributes->averageRating);
        $a->setFavoritesCount($anime->data->attributes->favoritesCount);
        $a->setStartDate($anime->data->attributes->startDate);
        $a->setEndDate($anime->data->attributes->endDate);
        $a->setPopularityRank($anime->data->attributes->popularityRank);
        $a->setRatingRank($anime->data->attributes->ratingRank);
        $a->setAgeRatingGuide($anime->data->attributes->ageRatingGuide);
        $a->setStatus($anime->data->attributes->status);
        $a->setPosterImage($anime->data->attributes->posterImage->original);
        $a->setCoverImage($anime->data->attributes->coverImage->small);
        $a->setEpisodeCount($anime->data->attributes->episodeCount);
        $a->setGenres($anime->data->relationships->genres->links->related);
        $a->setCategories($anime->data->relationships->categories->links->related);
        $a->setEpisodes($anime->data->relationships->episodes->links->related);

        return $a;

        error_reporting(E_ALL);
    }

    public function mangaId($id) {
        
        $manga = $this->setCurl($this->base_url."/manga/$id");

        error_reporting(E_ALL ^ E_WARNING);

        $a = new Manga();
        $a->setId($manga->data->id);
        $a->setType($manga->data->type);
        $a->setSelfLink($manga->data->links->self);
        $a->setCanonicalTitle($manga->data->attributes->canonicalTitle);
        $a->setSynopsis($manga->data->attributes->synopsis);
        $a->setAverageRating($manga->data->attributes->averageRating);
        $a->setFavoritesCount($manga->data->attributes->favoritesCount);
        $a->setStartDate($manga->data->attributes->startDate);
        $a->setEndDate($manga->data->attributes->endDate);
        $a->setPopularityRank($manga->data->attributes->popularityRank);
        $a->setRatingRank($manga->data->attributes->ratingRank);
        $a->setAgeRatingGuide($manga->data->attributes->ageRatingGuide);
        $a->setStatus($manga->data->attributes->status);
        $a->setPosterImage($manga->data->attributes->posterImage->original);
        $a->setCoverImage($manga->data->attributes->coverImage->small);
        $a->setGenres($manga->data->relationships->genres->links->related);
        $a->setCategories($manga->data->relationships->categories->links->related);
        $a->setSerialization($manga->data->attributes->serialization);
        $a->setMangaType($manga->data->attributes->subtype);
        $a->setChapterCount($manga->data->attributes->chapterCount);
        $a->setChapters($manga->data->relationships->chapters->links->related);

        return $a;

        error_reporting(E_ALL);
    }

    public function episodes($el) {

        $array = [];

        $list = $this->setCurl($el);

        foreach ($list->data as $item) {

            $e = new Episode;
            $e->setId($item->id);
            $e->setCanonicalTitle($item->attributes->canonicalTitle);
            $e->setSeasonNumber($item->attributes->seasonNumber);
            $e->setNumber($item->attributes->number);
            $e->setSynopsis($item->attributes->synopsis);
            $e->setAirDate($item->attributes->airdate);
            $e->setLength($item->attributes->length);
            $e->setThumbnail($item->attributes->thumbnail->original);

            $array[] = $e;
        }

        return $array;
        
    }

    public function episodeId($id) {

        $item = $this->setCurl($this->base_url."/episodes/".$id);
        
        $e = new Episode;
        $e->setId($item->data->id);
        $e->setCanonicalTitle($item->data->attributes->canonicalTitle);
        $e->setSeasonNumber($item->data->attributes->seasonNumber);
        $e->setNumber($item->data->attributes->number);
        $e->setSynopsis($item->data->attributes->synopsis);
        $e->setAirDate($item->data->attributes->airdate);
        $e->setLength($item->data->attributes->length);
        $e->setThumbnail($item->data->attributes->thumbnail->original);

        return $e;
    }
}
