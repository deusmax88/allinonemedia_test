<?php

namespace app\commands;


use yii\console\Controller;
use app\models\Post;
use app\models\Author;
use app\models\Language;

/**
 * Генератор случайных постов.
 */
class PostsController extends Controller
{
    /**
     * Запуск генерации случайных постов.
     */
    public function actionGeneratePosts()
    {
        $numOfPosts = 1;

        $headingWords = [
            'ru' => [
                "жесть", "удивительно", "снова", "совсем", "шок", "случай", "сразу", "событие", "начало", "вирус"
            ],
            'en' => [
                "currency", "amazing", "again", "absolutely", "shocking", "case", "immediately", "event", "beginning", "virus"
            ]
        ];
        $textWords = [
            'ru' => [
                "один", "еще", "бы", "такой", "только", "себя", "свое", "какой", "когда", "уже", "для", "вот", "кто", "да", "говорить", "год", "знать", "мой", "до", "или", "если", "время", "рука", "нет", "самый", "ни", "стать", "большой", "даже", "другой", "наш", "свой", "ну", "под", "где", "дело", "есть", "сам", "раз", "чтобы", "два", "там", "чем", "глаз", "жизнь", "первый", "день", "тута", "во", "ничто", "потом", "очень", "со", "хотеть", "ли", "при", "голова", "надо", "без", "видеть", "идти", "теперь", "тоже", "стоять", "друг", "дом", "сейчас", "можно", "после", "слово", "здесь", "думать", "место", "спросить", "через", "лицо", "что", "тогда", "ведь", "хороший", "каждый", "новый", "жить", "должный", "смотреть", "почему", "потому", "сторона", "просто", "нога", "сидеть", "понять", "иметь", "конечный", "делать", "вдруг", "над", "взять", "никто", "сделать"
            ],
            'en' => [
                "one", "yet", "would", "such", "only", "yourself", "his", "what", "when", "already", "for", "behold", "Who", "yes", "speak", "year", "know", "my", "before", "or", "if", "time", "arm", "no", "most", "nor", "become", "big", "even", "other", "our", "his", "well", "under", "where", "a business", "there is", "himself", "time", "that", "two", "there", "than", "eye", "a life", "first", "day", "mulberry", "in", "nothing", "later", "highly", "with", "to want", "whether", "at", "head", "need", "without", "see", "go", "now", "also", "stand", "friend", "house", "now", "can", "after", "word", "here", "think", "a place", "ask", "across", "face", "what", "then", "after all", "good", "each", "new", "live", "due", "look", "why", "because", "side", "just", "leg", "sit", "understand", "have", "finite", "do", "all of a sudden", "above", "to take", "no one", "make"
            ]
        ];

        $beginDate = new \DateTime("01.01.2017");
        $endDate = new \DateTime("08.08.2017");
        $interval = $endDate->diff($beginDate);
        $numOfDays = $interval->days;

        $authors = Author::find()->all();
        $languages = Language::find()->all();

        for ($i = 0; $i < $numOfPosts; $i++) {

            $currentLanguageIndex = rand(0, count($languages) - 1);
            $currentLanguage = $languages[$currentLanguageIndex];
            $currentLanguagePrefix = $currentLanguage->name == 'Русский' ? 'ru' : 'en';

            $currentAuthorIndex = rand(0, count($authors) - 1);
            $currentAuthor = $authors[$currentAuthorIndex];

            $postDate = new \DateTime("01.01.2017");
            $daysToAddToStartDate = rand(0, $numOfDays);
            $postDate->modify("+ " . $daysToAddToStartDate . " days");

            $numOfHeadingWords = rand(4, 6);
            $currentLanguageHeadingWords = $headingWords[$currentLanguagePrefix];
            $headingArray = array_rand(array_flip($currentLanguageHeadingWords), $numOfHeadingWords);
            $heading = join(" ", $headingArray);
            $heading = $this->upperCaseFirst($heading, "utf8");

            $currentLanguageTextWords = $textWords[$currentLanguagePrefix];

            $sentencesArray = [];
            $numOfSentences = rand(3, 4);
            for ($j = 0; $j < $numOfSentences; $j++) {
                $numOfWordsInSentence = rand(5, 8);
                $sentenceArray = array_rand(array_flip($currentLanguageTextWords), $numOfWordsInSentence);
                $sentence = join(" ", $sentenceArray);
                $sentence = $this->upperCaseFirst($sentence, "utf8");
                $sentence .= ".";

                $sentencesArray[] = $sentence;
            }
            $text = join(" ", $sentencesArray);

            $numOfLikes = rand(1, 100);

            $post = new Post();

            $post->author_id = $currentAuthor->id;
            $post->language_id = $currentLanguage->id;
            $post->publication_date = $postDate->format("Ymd");
            $post->heading = $heading;
            $post->text = $text;
            $post->num_of_likes = $numOfLikes;

            $post->save();
        }
    }

    private function upperCaseFirst($string, $encoding)
    {
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }
}