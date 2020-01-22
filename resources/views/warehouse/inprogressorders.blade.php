@extends('adminlte::page')

@section('title', 'Orders | LOYAL অভিযাত্রী')

@section('css')
  <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
  <style type="text/css">
    /* print css */
    @media print {
        header, .footer, footer {
            display: none;
        }

        /* hide main content when dialog open */
        body.modal-open div.container.body-content div#mainContent {
            display: none;
        }

        .noPrint {
            display: none;
        }

        .onlyPrint {
            display: block;
        }
    }
    /* print css */
  </style>
@endsection

@section('content_header')
    <h1>চলমান অর্ডারগুলো (In Progress Orders)</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-info">
        <div class="panel-heading">
          <i class="fa fa-hourglass-half" aria-hidden="true"></i> চলমান অর্ডারগুলো (In Progress Orders)
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th>অর্ডার আইডি</th>
                  <th>অর্ডারের সময়</th>
                  <th>পেমেন্ট মেথড</th>
                  <th>ডেলিভারি চার্জ</th>
                  <th>মোট পরিশোধনীয় মূল্য</th>
                  <th>Total Profit</th>
                  <th width="15%">কার্যক্রম</th>
                </tr>
              </thead>
              <tbody>
                @foreach($inprogressorders as $inprogressorder)
                <tr>
                  <td>{{ $inprogressorder->payment_id }}</td>
                  <td>{{ $inprogressorder->created_at->format('M d, Y, h:i A') }}</td>
                  <td>{{ payment_method($inprogressorder->payment_method) }}</td>
                  <td>৳ {{ $inprogressorder->cart->deliveryCharge }}</td>
                  <td>৳ {{ $inprogressorder->cart->totalPrice }}</td>
                  <td>৳ {{ $inprogressorder->cart->totalProfit }} {{-- {{ $inprogressorder->totalprofit }} --}}</td>
                  <td>
                    <a href="{{ route('warehouse.receiptpdf', [$inprogressorder->payment_id, generate_token(100)]) }}" class="btn btn-sm btn-primary" title="Print Invoice" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
                    <button class="btn btn-sm btn-info" type="button" title="Details" data-toggle="modal" data-target="#details{{ $inprogressorder->id }}" data-backdrop="static"><i class="fa fa-cogs" aria-hidden="true"></i></button>
                    <div class="modal fade modal{{ $inprogressorder->id }}" id="details{{ $inprogressorder->id }}" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header modal-header-info">
                            <button type="button" class="close noPrint" data-dismiss="modal">×</button>
                            <h2 class="onlyPrint">ইকমার্স</h2>
                            <h4 class="modal-title">অর্ডারের তারিখ ও সময়ঃ {{ $inprogressorder->created_at->format('F d, Y, h:i A') }}</h4>
                          </div>
                          <div class="modal-body">
                            <p>
                              <div class="row">
                                <div class="col-md-4">
                                  <div class="progress">
                                    <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar"
                                    aria-valuenow="67" aria-valuemin="0" aria-valuemax="100" style="width:67%">
                                      চলমান (In Progress)
                                    </div>
                                  </div>
                                  <h4>অর্ডার আইডিঃ <u>{{ $inprogressorder->payment_id }}</u></h4>
                                  <h4>ক্রেতার নামঃ {{ $inprogressorder->user->name }}</h4>
                                  <h4>ফোন নম্বরঃ <b>{{ $inprogressorder->user->phone }}</b></h4>
                                  <h4>পণ্য প্রেরণের ঠিকানাঃ
                                    @if($inprogressorder->deliverylocation == 1020)
                                      <b>{{ deliverylocation($inprogressorder->deliverylocation) }}</b>
                                    @else
                                      <b>{{ $inprogressorder->address }}</b>
                                    @endif
                                  </h4>
                                  <h4>পেমেন্ট মেথডঃ <b>{{ payment_method($inprogressorder->payment_method) }}</b></h4><br/>
                                </div>
                                <div class="col-md-8">
                                  <h4>অর্ডারের বিবরণঃ</h4>
                                  <ul class="list-group">
                                    @foreach($inprogressorder->cart->items as $item)
                                      <li class="list-group-item">
                                        {{ $item['item']['title'] }} / <small>৳ {{ $item['item']['price'] }}</small> / পরিমাণঃ {{ $item['qty'] }}
                                        <span class="badge">৳ {{ $item['price'] }}</span>
                                      </li>
                                    @endforeach
                                      <li class="list-group-item panel-footer-custom">
                                        <div class="row">
                                          <div class="col-md-12">
                                            <strong style="float: right;">
                                              মোট পরিশোধনীয় মূল্যঃ ৳ <big>{{ $inprogressorder->cart->totalPrice - $inprogressorder->cart->deliveryCharge + $inprogressorder->cart->discount }}</big>
                                            </strong>
                                            <br/><br/>
                                            <strong style="float: right !important;">ডেলিভারি চার্জঃ ৳ {{ $inprogressorder->cart->deliveryCharge }}</strong>
                                            <br/>
                                            <strong style="float: right !important;">ডিসকাউন্ট/ অর্জিত ব্যালেন্স থেকে পরিশোধঃ ৳ {{ $inprogressorder->cart->discount }}</strong>
                                            <br/>
                                            <span style="float: right !important;">
                                            ________________________</span><br/><br/>
                                            <strong style="float: right !important;">
                                              সর্বমোট পরিশোধনীয় মূল্যঃ ৳ <big>{{ $inprogressorder->cart->totalPrice }}</big>
                                            </strong>
                                          </div>
                                        </div>
                                      </li>
                                  </ul>
                                </div>
                              </div>
                            </p>
                          </div>
                          <div class="modal-footer noPrint">
                            {!! Form::model($inprogressorder, ['route' => ['warehouse.completeorder', $inprogressorder->id], 'method' => 'PUT']) !!}
                              <button type="submit" class="btn btn-info" title="নিষ্পন্ন তালিকায় পাঠান">অর্ডারটি নিষ্পন্ন করুন</button>
                              <a href="{{ route('warehouse.receiptpdf', [$inprogressorder->payment_id, generate_token(100)]) }}" class="btn btn-primary" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> প্রিন্ট করুন</a>
                              <button type="button" class="btn btn-default" data-dismiss="modal">বন্ধ করুন</button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                    </div>
                    {{-- <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> মুছে দিন</button> --}}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {{ $inprogressorders->links() }}
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <i class="fa fa-calendar-check-o" aria-hidden="true"></i> আজকের অর্ডারগুলো
        </div>
        <div class="panel-body">
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>অর্ডার আইডি</th>
                <th>অর্ডারের সময়</th>
                <th>অর্ডার স্ট্যাটাস</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orderstoday as $order)
              <tr>
                <td>{{ $order->payment_id }}</td>
                <td>{{ $order->created_at->format('h:i A') }}</td>
                <td align="center">
                  @if($order->status == 0)
                    <span class="label label-warning"><i class="fa fa-file-text-o" aria-hidden="true" title="{{ status($order->status) }}"></i></span>
                  @elseif($order->status == 1)
                    <span class="label label-info"><i class="fa fa-hourglass-half" aria-hidden="true" title="{{ status($order->status) }}"></i></span>
                  @elseif($order->status == 2)
                    <span class="label label-success"><i class="fa fa-check" aria-hidden="true" title="{{ status($order->status) }}"></i></span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
    
@stop