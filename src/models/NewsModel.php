<?php

namespace models;

use DOMDocument;
use DOMXPath;

class NewsModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function aiModel($prompt, $text, $returnType) {
        $data = json_encode([
            'prompt' => $prompt,
            'text' => $text
        ]);

        // Initialize cURL for LMS Studio API call
        $curl = curl_init();

        global $lmURL;
        $curlOptions = array(
            CURLOPT_URL => $lmURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data
        );

        if ($returnType === "json") {
            $curlOptions[CURLOPT_HTTPHEADER] = array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            );
        }

        curl_setopt_array($curl, $curlOptions);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'ai Curl error: ' . curl_error($curl);
            return false;
        }

        curl_close($curl);

        return $response;
    }

    public function receiveNews() {
        $curl = curl_init();

        global $rssURL;

        // Set the cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $rssURL,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1, // Should follow redirects
        ));

        // Fetch the RSS feed
        $rss = curl_exec($curl);

        // Check for errors
        if (curl_errno($curl)) {
            die('Re Curl error: ' . curl_error($curl));
        }

        // Close cURL resource
        curl_close($curl);

        // Parse the RSS feed
        $xml = simplexml_load_string($rss);

        // Check if parsing was successful
        if ($xml === false) {
            die('Error parsing XML');
        } else {
            return $xml;
        }
    }

    public function fetchNews() {
        $xml = $this->receiveNews();

        $translatePrompt = "translate it to persian!!"; // Should be replaced with a better prompt!!!!!!!
        $translateSummarizedPrompt = "summarize this as u can!!"; // Should be replaced with a better prompt!!!!!!!

        // Display the RSS feed items
        foreach ($xml->channel->item as $item) {
            $date = date("Y/m/d", strtotime($item->pubDate));
            $title = $this->conn->real_escape_string($item->title);
            $link = $item->link;
            $id = md5($title . $date);

            // Check if the news item already exists in the database
            $duplicateCheckQuery = "SELECT id FROM news WHERE id = '$id'";
            $duplicateCheck = $this->conn->query($duplicateCheckQuery);

            if ($duplicateCheck->num_rows === 0) { // Corrected condition to check if news doesn't exist
                $dom = new DOMDocument();

                $newsHtml = file_get_contents($link);

                libxml_use_internal_errors(true);

                // Load the HTML into the DOMDocument
                $dom->loadHTML($newsHtml);

                libxml_clear_errors();

                // Create a new DOMXPath instance
                $xpath = new DOMXPath($dom);

                // Define the XPath query to select the content of the article with the class 'at-body'
                $articleContentQuery = '//section[contains(@class, "at-body")]';

                // Execute the XPath query
                $nodes = $xpath->query($articleContentQuery);

                $articleText = '';
                if ($nodes->length > 0) {
                    // Iterate over the nodes and extract the text content
                    foreach ($nodes as $node) {
                        $articleText .= $node->textContent;
                    }

                    $translatedTitle = $this->aiModel($translatePrompt, $title, null);
                    $translatedArticleText = $this->aiModel($translatePrompt, $articleText, null);
                    $translatedArticleTextSummarized = $this->aiModel($translateSummarizedPrompt, $translatedArticleText, null);

                    $insertingDataQuery = "INSERT INTO news (id, title, date, link, article_text, translated_title, translated_text, translated_text_summarzied) VALUES ('$id', '$title', '$date', '$link', '$articleText', '$translatedTitle', '$translatedArticleText', '$translatedArticleTextSummarized')";

                    $this->conn->query($insertingDataQuery);

                    $this->fetchBlog($id, $date, $translatedTitle, $translatedArticleText, $translatedArticleTextSummarized);
                    $this->analyzeNews($id, $articleText);
                }
            }
        }
        return null; // Ensure fetchNews always returns something
    }

    public function analyzeNews($id, $articleText) {

        $promptText = "
    Check if it is about cryptocurrency or not, then see which currency it is about in symbols like BTC, the sentiment of that news is positive or negative, rate it between 0 and 100 like how much is negative or positive, and give the output in JSON format
        {\"about_crypto\": bool,
        \"crypto_symbol\": string,
        \"sentiment\": string,
        \"rate\": number}
    Without any explanation
    "; // Should be replaced with a better prompt!!!!!!!

        $analyzeResult = $this->aiModel($promptText, $articleText, "json");

        $analyzeResultDecoded = json_decode($analyzeResult, true);

        if ($analyzeResultDecoded['is_crypto_related']) {
            foreach ($analyzeResultDecoded['cryptos'] as $crypto) {
                // Extract details for each cryptocurrency
                $symbol = $this->conn->real_escape_string($crypto['crypto_symbol']);
                $sentiment = $this->conn->real_escape_string($crypto['sentiment']);
                $confidence = $this->conn->real_escape_string($crypto['confidence']);
                $sentimentIntensity = $this->conn->real_escape_string($crypto['sentiment-intensity']);
                $importance = $this->conn->real_escape_string($crypto['importance']);
                $explanation = $this->conn->real_escape_string($crypto['explanation']);

                // Insert data into the analyze table
                $insertingDataQuery = "
            INSERT INTO analyze (id, symbol, sentiment, confidence, sentiment_intensity, importance, explanation)
            VALUES ('$id', '$symbol', '$sentiment', '$confidence', '$sentimentIntensity', '$importance' , '$explanation')
        ";

                $this->conn->query($insertingDataQuery);
            }
        }
    }

    public function fetchBlog($id, $date, $title, $articleText, $articleTextSummarized)
    {
        $blogPrompt = "analyze this and give me 
    {
        symbol: string or array,
        sentiment: string,
        explanation: string
    }";

        $blogAnalyze = json_decode($this->aiModel($blogPrompt, $articleText, 'json'));
        $symbols = $blogAnalyze->symbols;
        $sentiments = $blogAnalyze->sentiments;
        $explanations = $blogAnalyze->explanations;

        $InsertBolgQuery = "INSERT INTO blog (id, title, date, article, symbols, sentiment, explanation) VALUES ('$id', '$title', '$date',  '$articleTextSummarized', '$symbols', '$sentiments', '$explanations')";

        $this->conn->query($InsertBolgQuery);
    }

    public function getBlogData($limit) {
        $blogQuery = "
        SELECT * 
        FROM blog 
        ORDER BY date DESC 
        LIMIT " . intval($limit);

        // Execute the query
        $result = $this->conn->query($blogQuery);

        // Initialize an empty array to hold the formatted blog data
        $newsData = [];

        // Loop through each result and format it into the desired array structure
        while ($row = $result->fetch_assoc()) {
            $newsData[] = [
                'title' => $row['title'],
                'article' =>$row['article'],
                'symbols' => $row['symbols'],
                'sentiment' => getAnalysisFromSentiment($row['sentiment']),
                'explanation' => $row['explanation']
            ];
        }

        return $newsData;
    }

    /**
     *
     * @param $currencies
     * @param $timeFrame
     * @return bool|string
     */
    public function bigAnalyze($currencies = "global", $timeFrame = 7)
    {
        $promptText = "Analyze this/these data and tell me give me  a sentiment: positive or negative or neutral, a sentiment intensity in percentage between 0 and 100. also check dates newer is more important!";

        // Determine the date range for the time frame
        $startDate = date('Y-m-d', strtotime("-{$timeFrame} days"));
        $endDate = date('Y-m-d');

        // SQL query to join the `news` and `analyz` tables and select the required fields
        $bigAnalyzeQuery = "
        SELECT news.title, analyz.symbol, analyz.sentiment, analyz.sentiment_intensity, news.date
        FROM news
        JOIN analyz ON news.id = analyz.id
        WHERE news.date BETWEEN '$startDate' AND '$endDate'
    ";

        // Add currency filtering if specific currencies are provided
        if ($currencies !== "global") {
            if (is_array($currencies)) {
                $currencyList = implode("', '", array_map([$this->conn, 'real_escape_string'], $currencies));
                $bigAnalyzeQuery .= " AND analyz.symbol IN ('$currencyList')";
            } else {
                $currency = $this->conn->real_escape_string($currencies);
                $bigAnalyzeQuery .= " AND analyz.symbol = '$currency'";
            }
        }

        $bigAnalyzeQuery .= " ORDER BY news.date DESC";

        // Execute the query
        $result = $this->conn->query($bigAnalyzeQuery);

        if ($result->num_rows > 0) {
            // Initialize an empty string for storing formatted text
            $outputText = "";

            // Fetch each row and append its details to the text output
            while ($row = $result->fetch_assoc()) {
                $title = $row['title'];
                $symbol = $row['symbol'];
                $sentiment = $row['sentiment'];
                $sentimentIntensity = $row['sentiment_intensity'];
                $date = $row['date'];

                $outputText .= " $title | $date | $symbol | Sentiment: $sentiment ($sentimentIntensity), \n";
            }

            return $this->aiModel($promptText, $outputText, null);
        } else {
            return "No news articles found for the specified criteria.";
        }

    }
}