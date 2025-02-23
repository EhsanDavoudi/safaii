<?php

namespace models;

use models\AdminModel;

class AdminNewsModel extends AdminModel
{
    private $newsTable = 'news';
    private $analyzeTable = 'analyzes';
    private $blogTable = 'blog';

    public function getNewss($start_limit, $results_per_page)
    {
        return $this->get($this->newsTable, $start_limit, $results_per_page);
    }

    public function getAnalyzes($start_limit, $results_per_page)
    {
        return $this->get($this->analyzeTable, $start_limit, $results_per_page);
    }

    public function getBlogs($start_limit, $results_per_page)
    {
        return $this->get($this->blogTable, $start_limit, $results_per_page);
    }

    public function getTotalNewss()
    {
        return $this->getTotal($this->newsTable);
    }

    public function getTotalAnalyzes()
    {
        return $this->getTotal($this->analyzeTable);
    }

    public function getTotalBlogs()
    {
        return $this->getTotal($this->blogTable);
    }

    public function newsInfo()
    {
        // Check if 'id' is set in the GET request
        if (isset($_GET['id'])) {
            // Sanitize the input to prevent SQL injection
            $newsID = $this->conn->real_escape_string($_GET['id']);

            // Use the general read function to fetch the user info
            $newsInfo = $this->read($this->newsTable, $newsID);

            // Check if a result is found
            if ($newsInfo) {
                return $newsInfo;
            } else {
                return "<h4>No Such User Found</h4>";
            }
        } else {
            return "<h4>No User ID Provided</h4>";
        }
    }

    public function analyzeInfo()
    {
        // Check if 'id' is set in the GET request
        if (isset($_GET['id'])) {
            // Sanitize the input to prevent SQL injection
            $analyseID = $this->conn->real_escape_string($_GET['id']);

            // Use the general read function to fetch the analysis info
            $analyseInfo = $this->read($this->analyzeTable, $analyseID);

            // Check if a result is found
            if ($analyseInfo) {
                return $analyseInfo;
            } else {
                return "<h4>No Such Analyse Found</h4>";
            }
        } else {
            return "<h4>No Analyse ID Provided</h4>";
        }
    }

    public function blogInfo()
    {
        // Check if 'id' is set in the GET request
        if (isset($_GET['id'])) {
            // Sanitize the input to prevent SQL injection
            $blogID = $this->conn->real_escape_string($_GET['id']);

            // Use the general read function to fetch the blog info
            $blogInfo = $this->read($this->blogTable, $blogID);

            // Check if a result is found
            if ($blogInfo) {
                return $blogInfo;
            } else {
                return "<h4>No Such Blog Found</h4>";
            }
        } else {
            return "<h4>No Blog ID Provided</h4>";
        }
    }

    public function createNews($title, $date, $link,  $articleText, $translatedTitle, $translatedArticleText, $translatedArticleTextSummarized)
    {
        $newsID = md5($title . $date);

        return $this->create($this->newsTable, ['id', 'title', 'date', 'link', 'article_text', 'translated_title', 'translated_text', 'translated_text_summarized'], [$newsID, $title, $date, $link, $articleText, $translatedTitle, $translatedArticleText, $translatedArticleTextSummarized]);
    }

    public function createAnalyse($title, $date, $symbol, $sentiment, $confidence, $sentimentIntensity, $importance , $explanation)
    {
        $newsID = md5($title . $date);

        return $this->create($this->analyzeTable, ['id', 'symbol', 'sentiment', 'confidence', 'sentiment_intensity', 'importance', 'explanation'], [$newsID, $symbol, $sentiment, $confidence, $sentimentIntensity, $importance , $explanation]);
    }

    public function createBlog($title, $date, $articleTextSummarized, $symbols, $sentiments, $explanations)
    {
        $newsID = md5($title . $date);

        return $this->create($this->blogTable, ['id', 'title', 'date', 'article', 'symbols', 'sentiment', 'explanation'], [$newsID, $title, $date,  $articleTextSummarized, $symbols, $sentiments, $explanations]);
    }

    public function editNews($id, $updateData = [])
    {
        $fieldsToUpdate = [
            'title' => $updateData['title'] ?? null,
            'date' => $updateData['date'] ?? null,
            'link' => $updateData['link'] ?? null,
            'article_text' => $updateData['article_text'] ?? null,
            'translated_title' => $updateData['translated_title'] ?? null,
            'translated_text' => $updateData['translated_text'] ?? null,
            'translated_text_summarized' => $updateData['translated_text_summarized'] ?? null
        ];

        if (!empty($updateData['title']) && !empty($updateData['date'])) {
            $fieldsToUpdate['id'] = md5($updateData['title'] . $updateData['date']);
        }

        return $this->edit($this->newsTable, $id, $fieldsToUpdate);
    }

    public function editAnalyze($id, $updateData = [])
    {
        $fieldsToUpdate = [
            'title' => $updateData['title'] ?? null,
            'date' => $updateData['date'] ?? null,
            'symbol' => $updateData['symbol'] ?? null,
            'sentiment' => $updateData['sentiment'] ?? null,
            'confidence' => $updateData['confidence'] ?? null,
            'sentiment_intensity' => $updateData['sentiment_intensity'] ?? null,
            'importance' => $updateData['importance'] ?? null,
            'explanation' => $updateData['explanation'] ?? null
        ];

        // Optionally update the 'id' based on title and date
        if (!empty($updateData['title']) && !empty($updateData['date'])) {
            $fieldsToUpdate['id'] = md5($updateData['title'] . $updateData['date']);
        }

        return $this->edit($this->analyzeTable, $id, $fieldsToUpdate);
    }

    public function editBlog($id, $updateData = [])
    {
        $fieldsToUpdate = [
            'title' => $updateData['title'] ?? null,
            'date' => $updateData['date'] ?? null,
            'article' => $updateData['article'] ?? null,
            'symbols' => $updateData['symbols'] ?? null,
            'sentiment' => $updateData['sentiment'] ?? null,
            'explanation' => $updateData['explanation'] ?? null
        ];

        // Optionally update the 'id' based on title and date
        if (!empty($updateData['title']) && !empty($updateData['date'])) {
            $fieldsToUpdate['id'] = md5($updateData['title'] . $updateData['date']);
        }

        return $this->edit($this->blogTable, $id, $fieldsToUpdate);
    }

    public function deleteNews($id)
    {
        return $this->delete($this->newsTable, $id);
    }

    public function deleteAnalyze($id)
    {
        return $this->delete($this->analyzeTable, $id);
    }

    public function deleteBlog($id)
    {
        return $this->delete($this->blogTable, $id);
    }
}