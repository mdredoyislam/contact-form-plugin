<form class="form-contact contact_form" action="contact_process.php" method="post" id="eiserContactForm" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
    <div class="row">
        <div class="col-12">
        <div class="form-group">
            <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" placeholder="Enter Message"></textarea>
            <small class="text-danger form-control-msg">Please Enter Your Message || This Field is Recuired</small>
        </div>
        </div>
        <div class="col-sm-6">
        <div class="form-group">
            <input class="form-control" name="name" id="name" type="text" placeholder="Enter your name">
            <small class="text-danger form-control-msg">Please Enter Your Name || This Field is Recuired</small>
        </div>
        </div>
        <div class="col-sm-6">
        <div class="form-group">
            <input class="form-control" name="email" id="email" type="email" placeholder="Enter email address">
            <small class="text-danger form-control-msg">Please Enter Your Mail || This Field is Recuired</small>
        </div>
        </div>
    </div>
    <div class="form-group mt-lg-3">
        <button type="submit" class="main_btn">Send Message</button>
        <small class="text-info form-control-msg js-form-submission">Submission In Process, Please Wait ......</small>
        <small class="text-success form-control-msg js-form-success">Message Successfuly Submited, Thank You!......</small>
        <small class="text-danger form-control-msg js-form-error">There was an error, Please Try Again ......</small>
    </div>
</form>