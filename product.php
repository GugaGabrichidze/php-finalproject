<?php
class Product
{
    public ?int $id;
    public string $name;
    public float $price;
    public string $img;

    public function __construct(?int $id, string $name, float $price, string $img)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->img = $img;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getImg()
    {
        return $this->img;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setPrice($price)
    {
        if ($price < 0) {
            throw new Exception("Price cannot be negative");
        }
        $this->price = $price;
    }
    public function setImg($img)
    {
        $this->img = $img;
    }
}
