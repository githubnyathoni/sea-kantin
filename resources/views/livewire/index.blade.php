<div>
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{$message}}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{$message}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row justify-content-end">
    	<div class="col-3">
    		<input type="text" class="form-control" wire:model="query" placeholder="Search..">
    	</div>
    	<div class="col-1">
    		<div class="dropdown d-flex justify-content-end">
			 	<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
			    {{$sortBy}}
			  	</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
				    <li><a class="dropdown-item" wire:click="$set('type', 'A-Z')">A-Z</a></li>
				    <li><a class="dropdown-item" wire:click="$set('type', 'Z-A')">Z-A</a></li>
				    <li><a class="dropdown-item" wire:click="$set('type', 'Newest')">Newest</a></li>
				    <li><a class="dropdown-item" wire:click="$set('type', 'Oldest')">Oldest</a></li>
				</ul>
			</div>
		</div>
    </div>
	<div class="row">
    @forelse($products as $product)
		<div class="col-md-3 mt-3">
			<div class="card" style="height: 27rem">
			  	<img src="/products/{{$product->image}}" height="250" class="card-img-top">
			  	<div class="card-body">
			    	<h5 class="card-title">{{$product->name}}</h5>
			    	<h6 class="card-subtitle mb-2 text-muted">
			    		<div class="d-flex justify-content-between">
			    			@rupiah($product->price)
			    			<span class="fst-italic">Stock: {{$product->stock}}</span>
			    		</div>
			    	</h6>
			    	<p
			    		class="card-text"
			    		style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box;
						   -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical;">{{$product->description}}
					</p>
					@if(Auth::user())
			    	<div class="position-absolute" style="right: 6%; bottom: 6%;">
			    		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buy{{$product->id}}Modal">Buy
						</button>
						<!-- Buy Modal -->
						<div class="modal fade" id="buy{{$product->id}}Modal" tabindex="-1" aria-labelledby="buy{{$product->id}}ModalLabel" aria-hidden="true">
						  	<div class="modal-dialog modal-dialog-centered">
							    <div class="modal-content">
								    <div class="modal-header">
								        <h5 class="modal-title" id="buy{{$product->id}}ModalLabel">Buy Product</h5>
								        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								    </div>
								    <!-- <form> -->
							      	<div class="modal-body">
							         	<div class="mb-3">
								            <label for="product-name" class="col-form-label">Product:</label>
								            <input type="text" class="form-control" id="product-name" value="{{$product->name}}" disabled>
							          	</div>
							          	<div class="row mb-3">
							          		<div class="col">
									            <label for="product-price" class="col-form-label">Price:</label>
									            <input type="text" class="form-control" id="product-price" value="@rupiah($product->price)" disabled>
									        </div>
									        <div class="col">
									            <label for="product-stock" class="col-form-label">Stock:</label>
									            <input type="text" class="form-control" id="product-stock" value="{{$product->stock}}" disabled>
									        </div>
									    </div>
								        <div class="row mb-3">
							          		<div class="col">
									            <label for="product-price" class="col-form-label">Qty:</label>
									            <input type="number" class="form-control" id="product-price" wire:model.defer="qty" min="0" max="{{$product->stock}}" required>
									        </div>
									        <div class="col">
									            <label for="product-stock" class="col-form-label">Pay:</label>
									            <input type="number" class="form-control" min="0" id="product-stock" wire:model.defer="pay" required>
									        </div>
									    </div>
									    <p class="text-muted text-center mb-0 fst-italic">Big Brother is watching you!</p>
							      	</div>
							      	<div class="modal-footer">
							        	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							        	<button type="submit" data-bs-dismiss="modal" wire:click="buyProduct({{$product->id}})" class="btn btn-primary" >Buy</button>
							      	</div>
							      <!-- </form> -->
							    </div>
						  	</div>
						</div>
			    	</div>
			    	@else
			    	<div class="position-absolute" style="right: 6%; bottom: 6%;">
			    		<a href="/login">
			    			<button type="button" class="btn btn-primary">Buy</button>
			    		</a>
					</div>
					@endif
			  	</div>
			</div>
		</div>
	@empty
		<p>There's no product here.</p>
	@endforelse
	</div>
</div>
