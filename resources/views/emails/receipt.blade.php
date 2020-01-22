<style type="text/css">
	table {
	    border-collapse: collapse;
	    width: 100% !important;
	}
	th, td{
	  padding: 7px;
	  font-family: 'kalpurush', sans-serif;
	  font-size: 15px;
	}
	.bordertable td, th {
	    border: 1px solid #A8A8A8;
	}
</style>
<body style="background: #F4F4F4;">
	<br/>
	<center>
	  <div style="border-top: 4px solid #E08E0B; padding: 10px; margin: 20px; max-width: 600px; background: #FFF; word-wrap: break-word; ">
	    <center>
	      <img src="{{ asset('images/logo.png') }}" width="100px; height: auto;">
	      {{-- <p style="font-size: 30px; color: #1B237D;"><b>LOYAL</b>অভিযাত্রী</p> --}}
	      <p style="font-size: 25px"><b>Invoice</b></p>
	      
	      {{-- <table style="width: 100%; word-wrap: break-word;">
	        <tr>
	          <td width="50%">
	            Customer Name: {{ $order->user->name }}<br/>
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
	          <td align="right">
	            <big>Invoice No: <b>{{ $order->payment_id }}</b></big> <br/>
	            Ordered at: {{ date('F d, Y h:i A', strtotime($order->created_at)) }}<br/>
	            Payment method: {{ payment_method($order->payment_method) }}
	          </td>
	        </tr>
	      </table> --}}
	      <div style="width: 50%; float: left; text-align: left;">
	      	Customer Name: {{ $order->user->name }}<br/>
	      	Customer ID: {{ $order->user->code }}<br/>
	      	Contact No: {{ $order->user->phone }}<br/>
	      	Email Address: {{ $order->user->email }}<br/>
	      	Delivery Address:<br/>
	      	@if($order->deliverylocation == 1020)
	      	  {{ deliverylocation($order->deliverylocation) }}
	      	@else
	      	  {{ $order->user->address }}
	      	@endif
	      </div>
	      <div style="width: 50%; float: left; text-align: right;">
	      	<big>Invoice No: <b>{{ $order->payment_id }}</b></big> <br/>
            Ordered at: {{ date('F d, Y h:i A', strtotime($order->created_at)) }}<br/>
            Payment method: {{ payment_method($order->payment_method) }}
	      </div>

	      <br/>

	      <table class="bordertable" border="1" style="width: 100%;">
	      	<thead>
	      		<tr>
	  		        <th width="40%">Product</th>
	  		        <th>Quantity</th>
	  		        <th>Price</th>
	  		        <th width="30%">Total</th>
	  		    </tr>
	      	</thead>
	      	<tbody>
	      		{{-- {{ $order->cart->items }} --}}
	      	  @foreach($order->cart->items as $item)
	      	  <tr>
	      	    <td>{{ $item['item']['title'] }}</td>
	      	    <td align="center">{{ $item['qty'] }}</td>
	      	    <td align="right">৳ {{ $item['item']['price'] }}</td>
	      	    <td align="right">৳ {{ $item['price'] }}</td>
	      	  </tr>
	      	  @endforeach
	      	  <tr>
	      	    <td colspan="3"></td>
	      	    <td align="right" style="line-height: 1.5em;">
	      	      SUBTOTAL ৳ {{ $order->cart->totalPrice - $order->cart->deliveryCharge + $order->cart->discount }}<br/>
	      	      Delivery Charge ৳ {{ $order->cart->deliveryCharge }}<br/>
	      	      Discount/ Earned Balance Usage ৳ {{ $order->cart->discount }}<br/>
	      	      <big>TOTAL ৳ {{ $order->cart->totalPrice }}</big>
	      	    </td>
	      	  </tr>
	      	</tbody>
	      </table><br/>

	      <big><a href="{{ route('warehouse.receiptpdf', [$order->payment_id, generate_token(100)]) }}" target="_blank"><b>Print Invoice</b></a></big><br/>
	      <br/><br/>
	      <p style="font-size: 12px; color: #ACACAC;">
	        This is a auto-generated email from LOYAL অভিযাত্রী. This email arrived to you because you (or may be someone else!) have ordered the above commoditie(s) associated with this email address. If you are getting this email by mistake, please ignore it.
	      </p>
	      <p style="font-size: 12px; color: #ACACAC;">
	        &copy; @php echo date('Y'); @endphp <a href="http://loyalovijatri.com/">LOYAL অভিযাত্রী</a>, Dhaka, Bangladesh
	      </p>
	    </center>
	  </div>
	</center>
	<br/>	
</body>
