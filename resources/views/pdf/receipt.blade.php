<html>
<head>
  <title>PDF | Receipt</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
  body {
    font-family: 'kalpurush', sans-serif;
  }

  table {
      border-collapse: collapse;
      width: 100%;
  }
  th, td{
    padding: 7px;
    font-family: 'kalpurush', sans-serif;
    font-size: 15px;
  }
  .bordertable td, th {
      border: 1px solid #A8A8A8;
  }
  .calibri_normal {
    font-family: Calibri;
    font-weight: normal;
  }
  @page {
    header: page-header;
    footer: page-footer;
    background: url({{ public_path('images/background_demo.png') }});
    background-size: cover;              
    background-repeat: no-repeat;
    background-position: center center;
  }
  </style>
</head>
<body>
  <h2 align="center">
    <img src="{{ public_path('images/logo.png') }}" style="height: 80px; width: auto;">
    <br/>
    <span class="calibri_normal">LOYAL</span> অভিযাত্রী<br/>
    <small class="calibri_normal" style="font-size: 14px;">Email: loyalovijatri@gmail.com, Phone: +88 01315 85 25 63</small>
  </h2>
  <h2 align="center" class="calibri_normal" style="color: #397736; border-bottom: 1px solid #397736;">
    INVOICE
  </h2>

  <table>
    <tr>
      <td class="calibri_normal">
        Customer Name: <span style="font-family: 'kalpurush', sans-serif;">{{ $order->user->name }}</span><br/>
        Customer ID: {{ $order->user->code }}<br/>
        Contact No: {{ $order->user->phone }}<br/>
        Email Address: {{ $order->user->email }}<br/>
        Delivery Address:<br/>
        @if($order->deliverylocation == 1020)
          {{ deliverylocation($order->deliverylocation) }}
        @else
          {{ $order->user->address }}
        @endif
        
      </td>
      <td align="right" class="calibri_normal">
        <big>Invoice No: <b>{{ $order->payment_id }}</b></big> <br/>
        Ordered at: {{ date('F d, Y h:i A', strtotime($order->created_at)) }}<br/>
        Payment method: {{ payment_method($order->payment_method) }}
      </td>
    </tr>
  </table><br/>

  <table class="bordertable">
    <thead>
      <tr>
        <th class="calibri_normal" width="40%">Product</th>
        <th class="calibri_normal">Quantity</th>
        <th class="calibri_normal">Price</th>
        <th class="calibri_normal" width="30%">Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($order->cart->items as $item)
      <tr>
        <td>{{ $item['item']['title'] }}</td>
        <td align="center" class="calibri_normal">{{ $item['qty'] }}</td>
        <td align="right">৳ <span class="calibri_normal">{{ $item['item']['price'] }}</span></td>
        <td align="right">৳ <span class="calibri_normal">{{ $item['price'] }}</span></td>
      </tr>
      @endforeach
      <tr>
        <td colspan="3"></td>
        <td align="right" class="calibri_normal" style="line-height: 1.5em;">
          SUBTOTAL <span style="font-family: 'kalpurush', sans-serif;">৳</span> {{ $order->cart->totalPrice - $order->cart->deliveryCharge + $order->cart->discount }}<br/>
          Delivery Charge <span style="font-family: 'kalpurush', sans-serif;">৳</span> {{ $order->cart->deliveryCharge }}<br/>
          Discount <span style="font-family: 'kalpurush', sans-serif;">৳</span> {{ $order->cart->discount }}<br/>
          <big>TOTAL <span style="font-family: 'kalpurush', sans-serif;">৳</span> {{ $order->cart->totalPrice }}</big>
        </td>
      </tr>
    </tbody>
  </table>
  <br/><br/><br/>

  <h3 align="center" style="color: #100569; font-family: Calibri;">
    Total in words: {{ convertNumberToWord($order->cart->totalPrice) }} Taka Only
  </h3><br/>

  <h4 align="center" style="font-family: Calibri;">
    If you have any questions about this invoice, please contact<br/>
    [+8801315852563, loyalovijatri@gmail.com]
  </h4>
  

  <htmlpagefooter name="page-footer">
    <small><span class="calibri_normal">Downloaded at:  {{ date('F d, Y, h:i A') }}</span></small><br/>
    <small class="calibri_normal" style="color: #3f51b5;">Powered by: Loence Bangladesh</small>
  </htmlpagefooter>
</body>
</html>