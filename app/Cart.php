<?php

namespace App;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $totalProfit = 0;
    public $deliveryCharge = 0;
    public $discount = 0;

    public function __construct($oldCart) {
      if ($oldCart) {
        $this->items = $oldCart->items;
        $this->totalQty = $oldCart->totalQty;
        $this->totalPrice = $oldCart->totalPrice;
        $this->totalProfit = $oldCart->totalProfit;
        $this->discount = $oldCart->discount;
        $this->deliveryCharge = $oldCart->deliveryCharge;
      }
    }

    public function add($item, $id) {
      $storedItem = ['qty' => 0, 'price' => $item->price, 'profit' => $item->profit, 
                      'item' => [
                        'id' => $item->id,
                        'title' => $item->title,
                        'price' => $item->price,
                        'profit' => $item->profit,
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
      $storedItem['profit'] = $item->profit * $storedItem['qty'];
      $this->items[$id] = $storedItem;
      $this->totalQty++;
      $this->totalPrice += $item->price;
      $this->totalProfit += $item->profit;
    }

    public function addByOne($id) {
      $this->items[$id]['qty']++;
      $this->items[$id]['price'] += $this->items[$id]['item']['price'];
      $this->items[$id]['profit'] += $this->items[$id]['item']['profit'];
      $this->totalQty++;
      $this->totalPrice += $this->items[$id]['item']['price'];
      $this->totalProfit += $this->items[$id]['item']['profit'];
    }

    public function reduceByOne($id) {
      $this->items[$id]['qty']--;
      $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
      $this->items[$id]['profit'] -= $this->items[$id]['item']['profit'];
      $this->totalQty--;
      $this->totalPrice -= $this->items[$id]['item']['price'];
      $this->totalProfit -= $this->items[$id]['item']['profit'];

      if($this->items[$id]['qty'] <= 0) {
        unset($this->items[$id]);
      }
    }

    public function removeItem($id) {
      $this->totalQty -= $this->items[$id]['qty'];
      $this->totalPrice -= $this->items[$id]['price'];
      $this->totalProfit -= $this->items[$id]['profit'];
      unset($this->items[$id]);
    }

    public function addDeliveryCharges($amount) {
      $this->deliveryCharge = $amount;
      $this->totalPrice = $this->totalPrice + $amount;
    }

    public function calculateEarnedBalance($amount) {
      $this->discount = $amount;
      $this->totalPrice = $this->totalPrice - $amount;
    }
}
