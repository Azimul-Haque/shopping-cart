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
	  <div style="border-top: 4px solid #E08E0B; padding: 10px; margin: 20px; max-width: 600px; background: #FFF; ">
	    <center>
	      <img src="{{ asset('images/logo.png') }}" width="100px; height: auto;">
	      {{-- <p style="font-size: 30px; color: #1B237D;"><b>Loyal</b>অভিযাত্রী</p> --}}
	      <p style="font-size: 25px"><b>Invoice</b></p>
	      
	      <table style="width: 100%;">
	        <tr>
	          <td>
	            Customer Name: {{ $order->user->name }}<br/>
	            Contact No: {{ $order->user->phone }}<br/>
	            Customer ID: {{ $order->user->code }}
	          </td>
	          <td align="right">
	            <big>Invoice No: <b>{{ $order->payment_id }}</b></big> <br/>
	            Ordered at: {{ date('F d, Y h:i A', strtotime($order->created_at)) }}
	          </td>
	        </tr>
	      </table><br/>

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
	      	      SUBTOTAL ৳ {{ $order->cart->totalPrice - $order->cart->deliveryCharge }}<br/>
	      	      Delivery Charge ৳ {{ $order->cart->deliveryCharge }}<br/>
	      	      Discount ৳ 0<br/>
	      	      <big>TOTAL ৳ {{ $order->cart->totalPrice }}</big>
	      	    </td>
	      	  </tr>
	      	</tbody>
	      </table><br/>

	      <big><a href="{{ route('warehouse.receiptpdf', [$order->payment_id, generate_token(100)]) }}" target="_blank"><b>Print Invoice</b></a></big><br/>
	      <br/><br/>
	      <p style="font-size: 12px; color: #ACACAC;">
	        This is a auto-generated email from Loyal অভিযাত্রী. This email arrived to you because you (or may be someone else!) have ordered the above commoditie(s) associated with this email address. If you are getting this email by mistake, please ignore it.
	      </p>
	      <p style="font-size: 12px; color: #ACACAC;">
	        &copy; @php echo date('Y'); @endphp <a href="http://loyalovijatri.com/">Loyal অভিযাত্রী</a>, Dhaka, Bangladesh
	      </p>
	    </center>
	  </div>
	</center>
	<br/>	
</body>
