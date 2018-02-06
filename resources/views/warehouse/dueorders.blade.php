@extends('partials.warehousepartials')

@section('title', 'Orders | Saudia Super Shop')

@section('warehousecontent')
  <div class="col-md-8">
    <h2><i class="fa fa-list-ol" aria-hidden="true"></i> পেন্ডিং অর্ডারগুলো</h2>
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>অর্ডারের সময়</th>
          <th>মোট পরিশোধনীয় মূল্য</th>
          <th>কার্যক্রম</th>
        </tr>
      </thead>
      <tbody>
        @foreach($dueorders as $dueorder)
        <tr>
          <td>{{ $dueorder->created_at->format('F d, Y, h:i A') }}</td>
          <td>৳ {{ $dueorder->cart->totalPrice }}</td>
          <td>
            <button class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#details{{ $dueorder->id }}" data-backdrop="static"><i class="fa fa-cogs" aria-hidden="true"></i> বিস্তারিত</button>
            <div class="modal fade modal{{ $dueorder->id }}" id="details{{ $dueorder->id }}" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header modal-header-warning">
                    <button type="button" class="close noPrint" data-dismiss="modal">×</button>
                    <h2 class="onlyPrint">সাউদিয়া সুপার শপ</h2>
                    <h4 class="modal-title">অর্ডারের তারিখ ও সময়ঃ {{ $dueorder->created_at->format('F d, Y, h:i A') }}</h4>
                  </div>
                  <div class="modal-body">
                    <p>
                      <div class="row">
                        <div class="col-md-4">
                          <h4>ক্রেতার নামঃ {{ $dueorder->user->name }}</h4>
                          <h4>ফোন নম্বরঃ <b>{{ $dueorder->user->phone }}</b></h4>
                          <h4>পণ্য প্রেরণের ঠিকানাঃ <b>{{ $dueorder->address }}</b></h4><br/>
                        </div>
                        <div class="col-md-8">
                          <h4>অর্ডারের বিবরণঃ</h4>
                          <ul class="list-group">
                            @foreach($dueorder->cart->items as $item)
                              <li class="list-group-item">
                                {{ $item['item']['title'] }} / <small>৳ {{ $item['item']['price'] }}</small> / পরিমাণঃ {{ $item['qty'] }}
                                <span class="badge">৳ {{ $item['price'] }}</span>
                              </li>
                            @endforeach
                              <li class="list-group-item panel-footer-custom">
                                <div class="row">
                                  <div class="col-md-12">
                                    <strong style="float: right;">
                                      মোট পরিশোধনীয় মূল্যঃ ৳ <big>{{ $dueorder->cart->totalPrice }}</big>
                                    </strong>
                                    @if($dueorder->cart->totalPrice < 300)
                                    <br/><br/>
                                    <strong style="float: right !important;">ডেলিভারি চার্জঃ ৳ 30</strong>
                                    <br/>
                                    <span style="float: right !important;">
                                    ________________________</span><br/><br/>
                                    <strong style="float: right !important;">
                                      সর্বমোট পরিশোধনীয় মূল্যঃ ৳ <big>{{ $dueorder->cart->totalPrice + 30 }}</big>
                                    </strong>
                                    @else
                                    <br/><br/>
                                    <strong style="float: right !important;">ডেলিভারি চার্জঃ ৳ 0</strong>
                                    <br/>
                                    <span style="float: right !important;">
                                    ________________________</span><br/><br/>
                                    <strong style="float: right !important;">
                                      সর্বমোট পরিশোধনীয় মূল্যঃ ৳ <big>{{ $dueorder->cart->totalPrice }}</big>
                                    </strong>
                                    @endif
                                  </div>
                                </div>
                              </li>
                          </ul>
                        </div>
                      </div>
                      <div class="onlyPrint"><br/>
                        ___________________<br/>
                        ক্রেতার স্বাক্ষর<br/>
                      </div>
                    </p>
                  </div>
                  <div class="modal-footer noPrint">
                    {!! Form::model($dueorder, ['route' => ['warehouse.confirmorder', $dueorder->id], 'method' => 'PUT']) !!}
                      <button type="submit" class="btn btn-success">অর্ডারটি কনফার্ম করুন</button>
                      <button type="button" class="btn btn-sm btn-primary" id="printModal{{ $dueorder->id }}"><i class="fa fa-print" aria-hidden="true"></i> প্রিন্ট করুন</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">বন্ধ করুন</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
              <script type="text/javascript">
                $('#printModal{{ $dueorder->id }}').on('click', function () {
                    if ($('.modal{{ $dueorder->id }}').is(':visible')) {
                        var modalId = $(event.target).closest('.modal{{ $dueorder->id }}').attr('id');
                        $('body').css('visibility', 'hidden');
                        $("#" + modalId).css('visibility', 'visible');
                        $('#' + modalId).removeClass('modal{{ $dueorder->id }}');
                        window.print();
                        $('body').css('visibility', 'visible');
                        $('#' + modalId).addClass('modal{{ $dueorder->id }}');
                    } else {
                        window.print();
                    }
                });
              </script>
            </div>
            <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> মুছে দিন</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="col-md-4">
    <h2><i class="fa fa-calendar-check-o" aria-hidden="true"></i> আজকের অর্ডারগুলো</h2>
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>অর্ডারের সময়</th>
          <th>অর্ডার স্ট্যাটাস</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orderstoday as $order)
        <tr>
          <td>{{ $order->created_at->format('h:i A') }}</td>
          <td>
            @if($order->paymentstatus == 'paid')
              <span class="label label-success"><i class="fa fa-check" aria-hidden="true"></i></span>
            @elseif($order->paymentstatus == 'not-paid')
              <span class="label label-info"><i class="fa fa-hourglass-start" aria-hidden="true"></i></span>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection

@section('scripts')
  
@endsection