<?php


namespace Api;


use Objects\Review;

class Handler {
    private $method; // Переданный метод
    private $db; // Объект базы данных

    public function __construct($method)   {
        $this->method = $method;
        $this->db = new \Database();
    }

    /**
     * @return String
     */
    public function validate() : String {
        // Проверяем методы
        switch ($this->method) {
            case 'getReviews':
                return $this->getReviews();
                break;
            case 'getReview':
                return $this->getReview();
                break;
            case 'createReview':
                return $this->createReview();
                break;
            default:
                return "Undefined '$this->method' method";
                break;
        }
    }

    public function getReviews() {
        // todo экранировать
        $order = $_GET['order']; // Возможные типы: rating, create
        $asc = $_GET['asc']; // Принимает логические значнения. Если true, то по возрастанию. Иначе - по убыванию
        $last_id = $_GET['last_id']; // Последний полученный ID отзыва (для пагинации)

        $query = 'select id, username, rating, photo_1 from reviews where id > '
            . ((isset($last_id) ? $last_id : 0)) // Если в запросе пришёл айдишник, то получаем отзывы начиная с последнего. Если не пришёл, то начинаем с первого
            . ' ';

        if (isset($order)) {
            if ($order == 'rating' or $order == 'create') { // сортировть по рейтингу или созданию
                $query .= 'order by ' . (($order == 'rating') ? 'rating' : 'created_at');
            }

            if (isset($asc)) {
                $query .= ' ' . (($asc == 'true') ? 'ASC' : 'DESC'); // Если true, то по возрастанию. Иначе - по убыванию
            }
        }

        $query .= ' LIMIT 10;';

        $result = $this->db->query($query);
        $reviewList = [];

        while ($review = $result->fetch_object(Review::class)) {
            array_push($reviewList, (object) $review);
        }

        return json_encode($reviewList, JSON_PRETTY_PRINT);
    }

    public function getReview() : string {
        $id = $_GET['id']; // ID отзыва, который нужно получить
        $fields = $_GET['fields']; // Строка с перечислением полей, разделённых запятой (ex. rating,created_at,text)

        if (empty($id))
            return 'ID cannot be null';

        $query = 'select username, rating, photo_1';

        if (isset($fields)) {
            $fields_list = explode(',', $fields);

            foreach ($fields_list as $field) {
                if ($field == 'text' || $field == 'photos') {
                    $query .= ', ' . (($field == 'text') ? 'text' : 'photo_2, photo_3');
                } else {
                    return 'Undefined fields';
                }
            }
        }

        $query .= ' from reviews where id = ' . $id;

        $result = $this->db->query($query);

        return json_encode($result->fetch_object(Review::class),JSON_PRETTY_PRINT);
    }

    public function createReview() : string {
        $username = html_entity_decode($_GET['username']);
        $photo_1 = html_entity_decode($_GET['photo_1']);
        $photo_2 = html_entity_decode($_GET['photo_2']);
        $photo_3 = html_entity_decode($_GET['photo_3']);
        $rating = (int) $_GET['rating'];
        $text = html_entity_decode($_GET['text']);

        if (empty($username) || strlen($username) > 50)
            return json_encode(["status"    =>  "error", "code" =>  "Invalid username"]);

        if (empty($rating) || !is_integer($rating) || $rating < 1 || $rating > 5)
            return json_encode(["status"    =>  "error", "code" =>  "Invalid rating"]);

        if (empty($text) || strlen($text) > 1000)
            return json_encode(["status"    =>  "error", "code" =>  "Invalid text"]);

        $query = "insert into reviews (username, text, photo_1, photo_2, photo_3, rating) VALUES 
                                                                               ('$username', '$text', '$photo_1', '$photo_2', '$photo_3', $rating);";

        $this->db->query($query);

        return json_encode(["status"    =>  "success", "last_id"    =>  $this->db->getLastInsertId()]);
    }
}