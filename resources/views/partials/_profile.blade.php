<div class="row">
  <div class="col-md-12">
    <div class="profile-sidebar thumbnail">
		<!-- SIDEBAR USERPIC -->
		<div class="profile-userpic">
			<center>
				<img src="{{ asset('images/user.png') }}" class="img-responsive img-circle" alt="" style="padding: 30px;">
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
					<span class="label label-default">{{ Auth::user()->role }}</span><br/><hr/>
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
				<li title="User ID"><a href="#"><i class="fa fa-id-card-o"></i> <b>{{ Auth::user()->code }}</b></a></li>
				<li title="Earned Balance"><a href="#"><i class="fa fa-money"></i> ৳ {{ Auth::user()->points }}</a></li>
				<li title="Contact No"><a href="#"><i class="fa fa-phone"></i> {{ Auth::user()->phone }}</a></li>
				<li title="Email Address"><a href="#"><i class="fa fa-envelope-o"></i> {{ Auth::user()->email }}</a></li>
				<li title="Delivery Address"><a href="#"><i class="fa fa-home"></i> {{ Auth::user()->address }}</a></li>
			</ul>
		</div>
		<!-- END MENU -->
	</div>
  </div>
</div>