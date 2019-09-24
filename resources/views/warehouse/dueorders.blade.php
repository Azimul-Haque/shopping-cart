@extends('adminlte::page')

@section('title', 'অর্ডারগুলো | ইকমার্স')

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
    <h1>পেন্ডিং অর্ডারগুলো</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <i class="fa fa-list-ol" aria-hidden="true"></i> পেন্ডিং অর্ডারগুলো
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
                  <th>কার্যক্রম</th>
                </tr>
              </thead>
              <tbody>
                @foreach($dueorders as $dueorder)
                <tr>
                  <td>{{ $dueorder->payment_id }}</td>
                  <td>{{ $dueorder->created_at->format('M d, Y, h:i A') }}</td>
                  <td>{{ payment_method($dueorder->payment_method) }}</td>
                  <td>৳ {{ $dueorder->cart->deliveryCharge }}</td>
                  <td>৳ {{ $dueorder->cart->totalPrice }}</td>
                  <td>
                    <button class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#details{{ $dueorder->id }}" data-backdrop="static"><i class="fa fa-cogs" aria-hidden="true"></i> বিস্তারিত</button>
                    <div class="modal fade modal{{ $dueorder->id }}" id="details{{ $dueorder->id }}" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header modal-header-warning">
                            <button type="button" class="close noPrint" data-dismiss="modal">×</button>
                            <h2 class="onlyPrint">ইকমার্স</h2>
                            <h4 class="modal-title">অর্ডারের তারিখ ও সময়ঃ {{ $dueorder->created_at->format('F d, Y, h:i A') }}</h4>
                          </div>
                          <div class="modal-body">
                            <p>
                              <div class="row">
                                <div class="col-md-4">
                                  <h4>অর্ডার আইডিঃ <u>{{ $dueorder->payment_id }}</u></h4>
                                  <h4>ক্রেতার নামঃ {{ $dueorder->user->name }}</h4>
                                  <h4>ফোন নম্বরঃ <b>{{ $dueorder->user->phone }}</b></h4>
                                  <h4>পণ্য প্রেরণের ঠিকানাঃ <b>{{ $dueorder->address }}</b></h4><br/>
                                  <h4>পেমেন্ট মেথডঃ <b>{{ payment_method($dueorder->payment_method) }}</b></h4><br/>
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
                                            <br/><br/>
                                            <strong style="float: right !important;">ডেলিভারি চার্জঃ ৳ {{ $dueorder->cart->deliveryCharge }}</strong>
                                            <br/>
                                            <span style="float: right !important;">
                                            ________________________</span><br/><br/>
                                            <strong style="float: right !important;">
                                              সর্বমোট পরিশোধনীয় মূল্যঃ ৳ <big>{{ $dueorder->cart->totalPrice }}</big>
                                            </strong>
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
                              <button type="button" class="btn btn-primary" id="printModal{{ $dueorder->id }}"><i class="fa fa-print" aria-hidden="true"></i> প্রিন্ট করুন</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">বন্ধ করুন</button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                      <script type="text/javascript">
                        $('#printModal{{ $dueorder->id }}').on('click', function () {
                            if($('.modal{{ $dueorder->id }}').is(':visible')) {
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
          {{ $dueorders->links() }}
        </div>
      </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-warning">
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
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
    
@stop