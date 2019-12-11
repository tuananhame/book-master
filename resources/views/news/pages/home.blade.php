@extends('news.layout.layout')

@section('content')
	@include('news.partials.about')
<section><a name="Product"></a>
				<h1 align="center">Ở đây chúng mình có gì?</h1>
				<p>Sách là nguồn tri thức vô tận. Hãy chia sẻ những cuốn sách hay của bạn cho mọi người và cùng nhau kết
					bạn tại đây nhé ^^</p>
				<input type="text" id="search-bar" name="search" value="Bạn muốn tìm sách gì?"
					onfocus="if (this.value=='Bạn muốn tìm sách gì?') this.value='';" />
				<div class="merch-sell">
					<?php if(isset($list_book)) { ?>
						@foreach($list_book as $item)
						<div class="greenl"><img
								src="https://toplist.vn/images/800px/con-giai-pho-co-nguyen-viet-ha-141899.jpg" width="200"
								height="250">
							<p>Con giai phố cổ</p>
							<a id="connect" href="{!! URL::route('user.borow_book',$item->id) !!}">Liên hệ mượn</a>
						</div>
						@endforeach	
					<?php }else {echo 'Dữu liệu đang cập nhật';} ?>				
				</div>
			</section>
@endsection

