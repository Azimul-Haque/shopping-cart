<div class="row">
  <div class="col-md-12">
    <div class="profile-sidebar thumbnail">
		<!-- SIDEBAR USERPIC -->
		<div class="profile-userpic">
			<center>
				<img src="{{ asset('images/user.png') }}" class="img-responsive img-circle" alt="" style="max-height: 120px; padding: 10px;">
			</center>
		</div>
		<!-- END SIDEBAR USERPIC -->
		<!-- SIDEBAR USER TITLE -->
		<div class="profile-usertitle">
			<center>
				<div class="profile-usertitle-name">
					<big><b>{{ Auth::user()->name }}</b></big>
				</div>
				<div class="profile-usertitle-job">
					<span class="label label-default">{{ ucfirst(Auth::user()->role) }}</span><br/><hr/>
				</div>
			</center>
		</div>
		<!-- END SIDEBAR USER TITLE -->
		<!-- SIDEBAR BUTTONS -->
		{{-- <div class="profile-userbuttons">
			<button type="button" class="btn btn-success btn-sm">Follow</button>
			<button type="button" class="btn btn-danger btn-sm">Message</button>
		</div> --}}
		<!-- END SIDEBAR BUTTONS -->
		<!-- SIDEBAR MENU -->
		<div class="profile-usermenu">
			<ul class="nav">
				<li title="এটি আপনার ইউজার আইডি। আইডিটি আপনার বন্ধু কেনার সময় ব্যবহার করলে আপনি বোনাস এমাউন্ট পাবেন!">
					<i class="fa fa-id-card-o"></i> <b>{{ Auth::user()->code }}</b>
				</li>
				<li title="Earned Balance"><i class="fa fa-money"></i> ৳ {{ Auth::user()->points }}</li>
				<li title="Contact No"><i class="fa fa-phone"></i> {{ Auth::user()->phone }}</li>
				<li title="Email Address"><i class="fa fa-envelope-o"></i> {{ Auth::user()->email }}</li>
				<li title="Delivery Address"><i class="fa fa-home"></i> {{ Auth::user()->address }}</li>
				<li class="text-center">
					<button class="highlight-button-dark btn btn-small" type="button" title="Edit Profile" data-toggle="modal" data-target="#editProfileModal" data-backdrop="static"><i class="fa fa-edit"></i> Edit Profile</button>
				</li>
			</ul>
		</div>
		<!-- END MENU -->
	</div>
  </div>
</div>