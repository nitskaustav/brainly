<section class="search-top">
        <div class="container">
        <form method="post" action="<?php echo $this->Url->build(["controller" => "services","action" => "result"]);?>">
            <div class="row">                
                <input type="hidden" name="lat" id="lat" value="">
                <input type="hidden" name="long" id="long" value="">
                <div class="col-lg-4 mb-1">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-3">
                            <p class="mt-1 mb-0">Location</p>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-9">
                            <div class="input-group">
                                <input type="text" name="location" id="autocomplete" class="form-control location" placeholder="Venue location">
                                <span class="icon"><i class="ion-location"></i></span>
                            </div>
                        </div>
                    </div>                   
                </div>
                <div class="col-lg-4 mb-1">
                     <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <p class="mt-1 mb-0">Venue Name</p>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control venue-location" placeholder="Venue name" name="title">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 mb-1">
                    <div class="mt-2" style="position: relative; width:100%">
                        <input multiple="" value="0,100" class="multirange original" type="range">
                        <input multiple="" value="0,200" class="multirange ghost" style="--low: 1%; --high: 40%;" type="range">
                    </div>
                </div>
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-primary btn-block"><i class="ion-search"></i> Search</button>
                </div>
            </div>
            </form>
        </div>
    </section>
    

    
    <section class="search-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Search</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Result</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-12">
                    <ul class="list-unstyled searchlist">
                        <?php
                            foreach ($services as $service) {
                        ?>
                        <li>
                            <div class="venue-image">
                                <img src="<?php echo $this->request->webroot;?>service_img/<?php echo $service->image;?>" alt="">
                                <div class="price"><small>From:</small> $<?php echo $service->price;?></div>
                            </div>
                            <article>
                                <h4 class="mb-1 text-uppercase"><?php echo $service->service_name;?></h4>
                                <p class="rating mb-1"><i class="ion-star"></i> <i class="ion-star"></i> <i class="ion-star"></i> <i class="ion-star"></i> <i class="ion-star"></i> (3.5)</p>
                                <p class="mb-1"><i class="ion-location"></i> <?php echo $service->address;?></p>
                                <p class="mb-1">Minutes walk from Hyde Park <a href="">(view on map)</a></p>
                                <p class="mb-1">Call <?php echo $service->cp_phone;?></p>
                                <button type="button" class="btn btn-primary">Book Now</button>
                                <a href="" class="fab"><i class="ion-ios-heart-outline"></i></a>
                            </article>
                        </li>
                        <?php
                            }
                        ?>                        
                        
                    </ul>
                </div>
                <div class="col-lg-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-5">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <script>     
      var placeSearch, autocomplete;   

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});   

             google.maps.event.addListener(autocomplete, 'place_changed', function() {
          var place = autocomplete.getPlace();
          var lat = place.geometry.location.lat();
          var lng = place.geometry.location.lng();
          $('#lat').val(lat);
          $('#long').val(lng);
        
        });     
      }

     
      function geolocate() { 
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) { 
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>

 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQ9hl89w8uiMND1-cnmkTVnqGh37TDvvk&libraries=places&callback=initAutocomplete"
        async defer></script>
