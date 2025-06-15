@extends('layouts.app')
@section('title', 'Sami Store | Contact Us')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
      <h2 class="page-title"><span>CONTACT</span> US</h2>
      </div>
    </section>

    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>

    <section class="contact-us container">
      <div class="mw-930">
        <div class="contact-us__form">
        <form id="contactForm" action="{{ route('contact.submit') }}" name="contact-us-form" method="POST" class="needs-validation" data-aos="fade-up" data-aos-delay="300">
        @csrf <!-- CSRF Token for security -->
            <h3 class="mb-5">Get In Touch</h3>
            <div class="form-floating my-4">
              <input type="text" class="form-control" name="name" placeholder="Name *" required>
              <label for="contact_us_name">Name *</label>
              <span class="text-danger"></span>
            </div>
            <div class="form-floating my-4">
              <input type="text" class="form-control" name="phone" placeholder="Phone *" required>
              <label for="contact_us_name">Phone *</label>
              <span class="text-danger"></span>
            </div>
            <div class="form-floating my-4">
              <input type="email" class="form-control" name="email" placeholder="Email address *" required>
              <label for="contact_us_name">Email address *</label>
              <span class="text-danger"></span>
            </div>
            <div class="form-floating my-4">
            <input type="text" class="form-control" name="subject" placeholder="Subject *" required>
            <label for="contact_us_subject">Subject *</label>
            <span class="text-danger"></span>
            </div>

            <div class="my-4">
              <textarea class="form-control form-control_gray" name="message" placeholder="Your Message" cols="30"
                rows="8" required=""></textarea>
              <span class="text-danger"></span>
            </div>
            <div class="my-4">
            <button type="submit" class="btn btn-primary">
                <span class="btn-text">Send Message</span>
                <span class="btn-loader" style="display: none;">
                    <i class="spinner-border spinner-border-sm"></i>
                </span>
            </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>
  @push('scripts')
  <script>
document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    const submitButton = contactForm.querySelector('button[type="submit"]');
    const btnText = submitButton.querySelector('.btn-text');
    const btnLoader = submitButton.querySelector('.btn-loader');

    contactForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Prevent default form submission

        // Disable the button and show the loader
        submitButton.disabled = true;
        btnText.style.display = 'none';
        btnLoader.style.display = 'inline-block';

        // Collect form data
        const formData = new FormData(contactForm);

        try {
            const response = await fetch(contactForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: formData,
            });

            if (response.ok) {
                // Replace loader with success icon and update button text
                btnLoader.style.display = 'none'; // Hide the loader
                btnText.innerHTML = `
                    <i class="bi bi-check-circle"></i>
                    Your Mail Has Been Sent!
                `;
                btnText.style.display = 'inline-block'; // Ensure the text is visible
            } else {
                console.error('Error sending form:', response.statusText);
            }
        } catch (error) {
            console.error('Error:', error);
        } finally {
            // Keep the button disabled after successful submission
            submitButton.disabled = true;
        }
    });
});
</script>
  @endpush
@endsection