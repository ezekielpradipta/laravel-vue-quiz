<?php

namespace App\Http\Controllers;

use App\Models\GenerateQuiz;
use App\Http\Requests\StoreGenerateQuizRequest;
use App\Http\Requests\UpdateGenerateQuizRequest;

class GenerateQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGenerateQuizRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGenerateQuizRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GenerateQuiz  $generateQuiz
     * @return \Illuminate\Http\Response
     */
    public function show(GenerateQuiz $generateQuiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GenerateQuiz  $generateQuiz
     * @return \Illuminate\Http\Response
     */
    public function edit(GenerateQuiz $generateQuiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGenerateQuizRequest  $request
     * @param  \App\Models\GenerateQuiz  $generateQuiz
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGenerateQuizRequest $request, GenerateQuiz $generateQuiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GenerateQuiz  $generateQuiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(GenerateQuiz $generateQuiz)
    {
        //
    }
}
