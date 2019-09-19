<div class="row">
  <div class="col-md-12">
    <div class="profile-sidebar thumbnail">
		<!-- SIDEBAR USERPIC -->
		<div class="profile-userpic">
			<img src="{{ asset('images/user.png') }}" class="img-responsive" alt="">
		</div>
		<!-- END SIDEBAR USERPIC -->
		<!-- SIDEBAR USER TITLE -->
		<div class="profile-usertitle">
			<div class="profile-usertitle-name">
				{{ Auth::user()->name }}
			</div>
			<div class="profile-usertitle-job">
				{{ Auth::user()->role }}
			</div>
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
				<li><a href="#"><i class="fa fa-phone"></i> {{ Auth::user()->phone }}</a></li>
				<li><a href="#"><i class="fa fa-envelope-o"></i> {{ Auth::user()->email }}</a></li>
				<li><a href="#"><i class="fa fa-home"></i> {{ Auth::user()->address }}</a></li>
			</ul>
		</div>
		<!-- END MENU -->
	</div>
  </div>
</div>