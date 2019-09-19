@extends('partials.warehousepartials')

@section('title', 'কাস্টমার তালিকা | ইকমার্স')

@section('warehousecontent')
  <div class="row">
    <div class="col-md-12">
      <h2><i class="fa fa-list-ol" aria-hidden="true"></i> কাস্টমার তালিকা</h2>
      <div class="table-responsive">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>নাম</th>
              <th>ফোন ও ইমেইল</th>
              <th width="30%">ঠিকানা</th>
              <th>মোট ক্রয় সংখ্যা</th>
              <th>পয়েন্ট</th>
              <th>সময়রেখা</th>
              <th width="10%">কার্যক্রম</th>
            </tr>
          </thead>
          <tbody>
            @foreach($customers as $dueorder)
            <tr>
              <td>
                <big>{{ $dueorder->name }}</big><br/>
                <span class="label label-success">ID: {{ $dueorder->code }}</span>
              </td>
              <td>
                <big><b>{{ $dueorder->phone }}</b></big><br/>
                {{ $dueorder->email }}
              </td>
              <td>{{ $dueorder->address }}</td>
              <td>{{ $dueorder->orders->count() }} বার</td>
              <td>{{ $dueorder->points }}</td>
              <td>
                প্রথম অর্ডারঃ 
                @if($dueorder->orders->first())
                  {{ $dueorder->orders->first()->created_at->format('M d, Y') }}
                @else
                  N/A
                @endif <br/>
                সর্বশেষ অর্ডারঃ 
                @if($dueorder->orders->last())
                  {{ $dueorder->orders->last()->created_at->format('M d, Y') }}
                @else
                  N/A
                @endif
              </td>
              <td>           
                <button class="btn btn-sm btn-primary" title="সম্পাদনা"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                <button class="btn btn-sm btn-danger" title="ডিলেট"><i class="fa fa-trash" aria-hidden="true"></i></button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $customers->links() }}
    </div>
    <div class="col-md-2">
      {{-- <h2><i class="fa fa-calendar-check-o" aria-hidden="true"></i> </h2> --}}
      
    </div>
  </div>
@endsection

@section('scripts')
  
@endsection