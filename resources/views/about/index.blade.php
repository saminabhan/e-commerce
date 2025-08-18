@extends('layouts.app')
@section('title', 'Sami Store | About Us')

@section('content')
<style>
    .p-4.bg-light {
  transition: all 0.3s ease;
  cursor: pointer;
}

.p-4.bg-light:hover {
  transform: translateY(-8px) scale(1.03);
  background-color: #ffffff;
  box-shadow: 0 8px 20px #4062B1;
  border: 1px solid #f0f0f0;
}

</style>
<main class="pt-90">
 <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
      <h2 class="page-title"><span>ABOUT</span> US</h2>
      </div>
    </section> 

    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>
    
    <section class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <img src="{{ asset('assets/images/about/store-front.png') }}" 
                     alt="Sami Store" 
                     class="img-fluid rounded-3 shadow-sm">
            </div>
            <div class="col-md-6">
                <h3 class="mb-3">Welcome to Sami Store</h3>
                <p>
                    Sami Store is your trusted online destination for quality products, 
                    seamless shopping experience, and excellent customer service. 
                    Since our launch, we’ve been committed to offering a wide variety 
                    of products at fair prices, making shopping simple and enjoyable.
                </p>
                <p>
                    Our goal is to bring you the latest and most reliable products 
                    with fast delivery and secure checkout. Whether you’re shopping 
                    for fashion, electronics, or lifestyle goods, we are here to serve you. 
                </p>
            </div>
        </div>

        <div class="row text-center mb-5">
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-light rounded-3 h-100 shadow-sm">
                    <h4>Our Mission</h4>
                    <p>
                        To deliver high-quality products with an easy and reliable 
                        shopping experience that our customers can always count on.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-light rounded-3 h-100 shadow-sm">
                    <h4>Our Vision</h4>
                    <p>
                        To be one of the most loved online stores, 
                        known for trust, quality, and customer satisfaction.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-light rounded-3 h-100 shadow-sm">
                    <h4>Our Values</h4>
                    <p>
                        Integrity, customer-first approach, 
                        and continuous improvement are at the heart of everything we do.
                    </p>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6 order-md-2">
                <img src="{{ asset('assets/images/about/team.png') }}" 
                     alt="Our Team" 
                     class="img-fluid rounded-3 shadow-sm">
            </div>
            <div class="col-md-6 order-md-1">
                <h3 class="mb-3">Meet Our Team</h3>
                <p>
                    Behind Sami Store is a passionate team that works hard to ensure 
                    you have the best shopping experience. From sourcing quality products 
                    to providing excellent support, our team is here for you every step of the way.
                </p>
                <p>
                    Thank you for trusting us and being part of the Sami Store family.
                </p>
            </div>
        </div>
    </section>
</main>
@endsection