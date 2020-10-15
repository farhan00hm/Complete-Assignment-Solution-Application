@extends('member.template3')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-xl-12 col-lg-12 content-left-offset">
			<h3 class="page-title">Select Category</h3>
			<div class="notify-box margin-top-15">
				<div class="switch-container">
					<span class="switch-text">Click a category below to select it</span>
				</div>

				<div class="sort-by">
					<span>Sort by:</span>
					<select class="selectpicker hide-tick">
						<option value="all">All Categories</option>
						@foreach($cats as $cat)
							<option value="{{ $cat->id }}">{{ $cat->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div class="tasks-list-container tasks-grid-layout margin-top-35">
				@foreach($subCats as $sub)
					<a href="/homeworks/new?category={{ $sub->name }}&uuid={{ $sub->uuid }}" class="task-listing">
						<div class="task-listing-details">
							<div class="task-listing-description">
								<h3 class="task-listing-title">{{ $sub->name }}</h3>
								<ul class="task-icons">
									<img src="{{ $sub->poster_url }}" style="width: 300px; height: 150px; padding: 0 !important; margin: 0 !important;">
								</ul>
							</div>
						</div>
						<div class="task-listing-bid">
							<div class="task-listing-bid-inner">
								<div class="task-offers">
									<span>{{ $sub->description }}</span>
								</div>
							</div>
						</div>
					</a>
				@endforeach
			</div>

		</div>
	</div>
</div>
@endsection