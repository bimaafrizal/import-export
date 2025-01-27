 <footer id="footer" class="footer dark-background">

     <div class="footer-top">
         <div class="container">
             <div class="row gy-4">
                 <div class="col-lg-4 col-md-6 footer-about">
                     <a href="#hero" class="logo d-flex align-items-center">
                         @if (!empty($landingPage['logo']))
                             <img src="{{ asset($landingPage['logo']) }}" alt="">
                         @endif
                     </a>
                     <div class="footer-contact pt-3">
                         <p>{{ $requiredContacts['alamat']['value'] }}</p>
                         <p class="mt-3"><strong>Phone:</strong>
                             <span>{{ $requiredContacts['telepon']['value'] }}</span></p>
                         <p><strong>Email:</strong> <span>{{ $requiredContacts['email']['value'] }}</span></p>
                     </div>
                     <div class="social-links d-flex mt-4">
                         @foreach ($socialMedias as $item)
                             <a href="{{ $item['value'] }}" target="_blank"><i class="{{ $item['icon'] }}"></i></a>
                         @endforeach
                     </div>
                 </div>

             </div>
         </div>
     </div>

 </footer>
