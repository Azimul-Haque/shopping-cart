@extends('adminlte::page')

@section('title', 'ডেলিভার্ড অর্ডারগুলো | ইকমার্স')

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
    <h1>ডেলিভার্ড অর্ডারগুলো</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-10">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <i class="fa fa-list-ol" aria-hidden="true"></i> ডেলিভার্ড অর্ডারগুলো
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th>অর্ডার আইডি</th>
                  <th>অর্ডারের সময়</th>
                  <th>মোট পরিশোধনীয় মূল্য</th>
                  <th>কার্যক্রম</th>
                </tr>
              </thead>
              <tbody>
                @foreach($completedorders as $dueorder)
                <tr>
                  <td>{{ $dueorder->payment_id }}</td>
                  <td>{{ $dueorder->created_at->format('M d, Y, h:i A') }}</td>
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
                            <button type="button" class="btn btn-primary" id="printModal{{ $dueorder->id }}"><i class="fa fa-print" aria-hidden="true"></i> প্রিন্ট করুন</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">বন্ধ করুন</button>
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
          {{ $completedorders->links() }}
        </div>
      </div>
    </div>
    <div class="col-md-2">
      {{-- <h2><i class="fa fa-calendar-check-o" aria-hidden="true"></i> </h2> --}}
      
    </div>
  </div>
@endsection

@section('js')
    
@stop