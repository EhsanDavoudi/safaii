<?php

namespace controllers;

class AdminNewsController extends AdminController
{
    private $newsType = 'news';
    private $analyzeType = 'analyze';
    private $blogType = 'blog';

    public function news()
    {
        $this->listEntities($this->newsType);
    }

    public function analyze() {
        $this->listEntities($this->analyzeType);
    }

    public function blog() {
        $this->listEntities($this->blogType);
    }

    public function viewNews()
    {
        $this->viewEntity($this->newsType);
    }

    public function viewAnalyze() {
        $this->viewEntity($this->analyzeType);
    }

    public function viewBlog() {
        $this->viewEntity($this->blogType);
    }

    public function createNews()
    {
        $fields = ['title', 'date', 'link', 'article_text', 'translated_title', 'translated_text', 'translated_text_summarized'];

        $duplicateFields = [
            'id' => md5($_POST['title'] . $_POST['date']),
        ];

        $this->createEntity($this->newsType, $fields, $fields, $duplicateFields);
    }

    public function createAnalyze()
    {
        $fields = ['symbol', 'sentiment', 'confidence', 'sentiment_intensity', 'importance', 'explanation'];

        $requiredFields = ['symbol', 'sentiment', 'sentiment_intensity', 'explanation'];

        $this->createEntity($this->analyzeType, $fields, $requiredFields);
    }

    public function createBlog()
    {
        $fields = ['title', 'date', 'article', 'symbols', 'sentiment', 'explanation'];

        $duplicateFields = [
            'article' => $_POST['article'],
            'id' => md5($_POST['title'] . $_POST['date'])
        ];

        $this->createEntity($this->blogType, $fields, $fields, $duplicateFields);
    }

    public function editNews()
    {
        $fields = ['title', 'date', 'link', 'article_text', 'translated_title', 'translated_text', 'translated_text_summarized'];

        $duplicateFields = [
            'id' => md5($_POST['title'] . $_POST['date']) ?? ''
        ];

        $this->editEntity($this->newsType, $fields, $fields, $duplicateFields);
    }

    public function editAnalyze()
    {
        $fields = ['symbol', 'sentiment', 'confidence', 'sentiment_intensity', 'importance', 'explanation'];

        $requiredFields = ['symbol', 'sentiment', 'sentiment_intensity', 'explanation'];

        $this->editEntity($this->analyzeType, $fields, $requiredFields);
    }

    public function editBlog()
    {
        $fields = ['title', 'date', 'article', 'symbols', 'sentiment', 'explanation'];

        $duplicateFields = [
            'article' => $_POST['article'] ?? '',
            'id' => md5($_POST['title'] . $_POST['date']) ?? ''
        ];

        $this->editEntity($this->blogType, $fields, $fields, $duplicateFields);
    }

    public function deleteNews() {
        $this->deleteEntity($this->newsType);
    }

    public function deleteAnalyze() {
        $this->deleteEntity($this->analyzeType);
    }

    public function deleteBlog() {
        $this->deleteEntity($this->blogType);
    }
}