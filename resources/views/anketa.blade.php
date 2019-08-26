@extends('layouts.app')

@section('content')
    <div class="col-lg-8 col-md-10 mx-auto">
        <div>Selected profile &laquo;<span class="uppercase">{{ $litera }}</span>&raquo;</div>

        <p>Want to get in touch? Fill out the form below to send me a message and I will get back to you as soon as possible!</p>
        <form name="sentMessage" id="contactForm" novalidate>
            <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                    <label>First Name</label>
                    <input type="text" class="form-control" placeholder="First Name" name="first_name" required data-validation-required-message="Please enter your first name.">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                    <label>Last Name</label>
                    <input type="text" class="form-control" placeholder="Last Name" name="last_name" required data-validation-required-message="Please enter your last name.">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Phone Number</label>
                    <input type="tel" class="form-control" placeholder="Phone Number, (XXX) XXX XX XX" name="phone" required data-validation-required-message="Please enter your phone number.">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                    <label>Email Address</label>
                    <input type="email" class="form-control" placeholder="Email Address" name="email" required data-validation-required-message="Please enter your email address.">
                    <p class="help-block text-danger"></p>
                </div>
            </div>

            <div class="control-group-select">
                <div class="form-group controls">
                    <label for="formControlSelect">Education</label>
                    <select class="form-control" name="education" id="formControlSelect" required data-validation-required-message="Please chouse a education.">
                        <option value="">-- select --</option>
                        <option value="Bachelor">Bachelor</option>
                        <option value="Master">Master</option>
                        <option value="PhD">PhD</option>
                    </select>
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <br>
            <div id="success"></div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="sendMessageButton">Send</button>
            </div>
        </form>

        @include('partials.content', ['html' => $content])
    </div>
@endsection