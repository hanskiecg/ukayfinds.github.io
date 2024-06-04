<?php

class Product
{
    public $image;
    public $price;
    public $name;

    public function __construct($image, $price, $name)
    {
        $this->image = $image;
        $this->price = $price;
        $this->name = $name;
    }

    public function displayCard()
    {
        $card = '
            <div class="card" style="width: 18rem;">
                <img src="' . $this->image . '" class="card-img-top" alt="Product Image">
                <div class="card-body">
                    <h5 class="card-title">' . $this->name . '</h5>
                    <p class="card-text">Price: ' . $this->price . '</p>
                </div>
            </div>
        ';
        return $card;
    }
}
?>
