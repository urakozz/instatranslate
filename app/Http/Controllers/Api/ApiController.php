<?php namespace App\Http\Controllers\Api;

use App\Components\Translator\Repository\TranslationRepositoryCache;
use App\Components\Translator\Translator;
use App\Components\Translator\TranslatorAdapter\BingTranslator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Kozz\Laravel\Facades\Guzzle;
use Kozz\Laravel\LaravelDoctrineCache;
use Response;

class ApiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $cache = new TranslationRepositoryCache(new LaravelDoctrineCache());
        $translation = $cache->get($id);
        return new JsonResponse(['id'=>$id, 'translation'=>$translation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
