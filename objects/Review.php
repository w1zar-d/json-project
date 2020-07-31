<?php

namespace Objects;

class Review implements \JsonSerializable
{
    private $id;
    private $username;
    private $rating;
    private $created_at;
    private $photo_1;
    private $photo_2;
    private $photo_3;

    /**
     * @return mixed
     */
    public function getPhoto2()
    {
        return $this->photo_2;
    }

    /**
     * @return mixed
     */
    public function getPhoto3()
    {
        return $this->photo_3;
    }
    private $text;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @return mixed
     */
    public function getText() {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getPhoto1()
    {
        return $this->photo_1;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @param mixed $photo_1
     */
    public function setPhoto1($photo_1)
    {
        $this->photo_1 = $photo_1;
    }

    /**
     * @param mixed $photo_2
     */
    public function setPhoto2($photo_2)
    {
        $this->photo_2 = $photo_2;
    }

    /**
     * @param mixed $photo_3
     */
    public function setPhoto3($photo_3)
    {
        $this->photo_3 = $photo_3;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }




    public function jsonSerialize()
    {
        return array_filter([
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'text' => $this->getText(),
            'photo_1' => $this->getPhoto1(),
            'photo_2' => $this->getPhoto2(),
            'photo_3' => $this->getPhoto3(),
            'rating' => $this->getRating(),
            'created_at' => $this->getCreatedAt(),
        ]);
    }
}