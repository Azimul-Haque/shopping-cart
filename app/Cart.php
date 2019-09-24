<?php

namespace App;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $deliveryCharge = 0;

    public function __construct($oldCart) {
      if ($oldCart) {
        $this->items = $oldCart->items;
        $this->totalQty = $oldCart->totalQty;
        $this->totalPrice = $oldCart->totalPrice;
        $this->deliveryCharge = $oldCart->deliveryCharge;
      }
    }

    public function add($item, $id) {
      $storedItem = ['qty' => 0, 'price' => $item->price, 
                      'item' => [
                        'id' => $item->id,
                        'title' => $item->title,
                        'price' => $item->price,
                        'productimages' => $item->productimages,
                        'code' => $item->code
                      ]
                    ];

      if($this->items) {
        if(array_key_exists($id, $this->items)) {
          $storedItem = $this->items[$id];
        }
      }
      $storedItem['qty']++;
      $storedItem['price'] = $item->price * $storedItem['qty'];
      $this->items[$id] = $storedItem;
      $this->totalQty++;
      $this->totalPrice += $item->price;
    }

    public function addByOne($id) {
      $this->items[$id]['qty']++;
      $this->items[$id]['price'] += $this->items[$id]['item']['price'];
      $this->totalQty++;
      $this->totalPrice += $this->items[$id]['item']['price'];
    }

    public function reduceByOne($id) {
      $this->items[$id]['qty']--;
      $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
      $this->totalQty--;
      $this->totalPrice -= $this->items[$id]['item']['price'];

      if($this->items[$id]['qty'] <= 0) {
        unset($this->items[$id]);
      }
    }

    public function removeItem($id) {
      $this->totalQty -= $this->items[$id]['qty'];
      $this->totalPrice -= $this->items[$id]['price'];
      unset($this->items[$id]);
    }

    public function addDeliveryCharges($amount) {
      $this->deliveryCharge = $amount;
      $this->totalPrice = $this->totalPrice + $amount;
    }

}
