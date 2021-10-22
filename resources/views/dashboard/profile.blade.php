@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Profile')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/sweetalert2.min.css">
    <style>
        .custom-control.custom-switch p{
            color: rgba(34, 41, 47, 0.4) !important;
            -webkit-transition: all 0.25s ease-in-out;
            transition: all 0.25s ease-in-out;
            opacity: 1;
            padding: 0.25rem 0;
            font-size: 0.7rem;
            top: -22px;
            left: -5px;
            position: absolute;
            display: block;
            pointer-events: none;
            cursor: text;
            margin-bottom: 0;
        }
        .custom-control.custom-switch .custom-control-label{
            margin-top: 0.4rem;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="/css/pages/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="/css/pages/dropzone.css">
@endpush

@section('content')
    <div class="dropzone-previews d-none"></div>
    <section class="users-edit">
        <div class="card">
            <div class="card-header justify-content-center">
                <h4 class="card-title"><i class="feather icon-user-plus"></i> Edit Profile</h4>
            </div>
            <div class="card-content">
                <div class="card-body">

                    <div class="row">
                        <div class="col-auto">
                            <div class="media mb-3">
                                <a class="mr-2 my-25" href="#">
                                    <img src="{{ Auth::user()['image'] }}" alt="users avatar" class="users-avatar-shadow rounded" width="90" height="90">
                                </a>
                                <div class="media-body mt-50">
                                    <h4 class="media-heading">{{ Auth::user()['name'] }}</h4>

                                    <div class="col-12 d-flex mt-1 px-0">
                                        <button id="dpz-single-file" class="btn btn-primary d-none d-sm-block mr-75 waves-effect waves-light">Change <i class="fa fa-spinner fa-spin d-none"></i></button>
                                        <button class="btn btn-primary d-block d-sm-none mr-75 waves-effect waves-light"><i class="feather icon-edit-1"></i></button>
                                        <button data-toggle="post-feed" data-feed="/profile/image/remove" class="btn btn-outline-danger d-none d-sm-block waves-effect waves-light">Remove</button>
                                        <button data-toggle="post-feed" data-feed="/profile/image/remove" class="btn btn-outline-danger d-block d-sm-none waves-effect waves-light"><i class="feather icon-trash-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="media-body mt-50">
                                <h4 class="media-heading">2FA Status</h4>
                                <div class="col-12 d-flex mt-1 px-0">
                                    <button data-toggle="post-feed" data-feed="/profile/2fa/change" data-text="{{ Auth::user()['2fa_mode'] === 'ENABLED'?'Disable 2FA! Are you sure you want to do this ?':"<div class='row justify-content-center'><img src='" .App\Traits\GoogleAuthenticator::Make()->getQRCodeGoogleUrl(env('APP_NAME'),Auth::user()['2fa_secret'])."'></div><br>Please scan the QR code in the google authenticator app. <br><b>You will be locked out if you do not scan and Enable 2FA</b>.<br>You will be required to enter pin after this.<br><br> Enable 2FA ?" }}" class="btn btn-info mr-75 waves-effect waves-light">{{ @Auth::user()['2fa_mode']==='ENABLED'?'Disable':'Enable' }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form class="form" action="/profile" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-6">
                                <div class="form-label-group position-relative has-icon-left">
                                    <input type="text" id="first-name-floating-icon" class="form-control" placeholder="Full Name" name="name" value="{{ @Auth::user()['name'] }}">
                                    <div class="form-control-position">
                                        <i class="feather icon-user"></i>
                                    </div>
                                    <label for="first-name-floating-icon">Full Name</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="form-label-group position-relative has-icon-left">
                                    <input type="email" id="email-id-floating-icon" class="form-control" name="email" placeholder="Email" value="{{ @Auth::user()['email'] }}">
                                    <div class="form-control-position">
                                        <i class="feather icon-mail"></i>
                                    </div>
                                    <label for="email-id-floating-icon">Email</label>

                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="form-label-group position-relative has-icon-left">
                                    <input type="text" id="phone-floating-icon" class="form-control" placeholder="Phone" name="phone" value="{{ @Auth::user()['phone'] }}">
                                    <div class="form-control-position">
                                        <i class="feather icon-phone"></i>
                                    </div>
                                    <label for="phone-floating-icon">Phone</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-6">
                                <div class="form-label-group position-relative has-icon-left">
                                    <input type="text" id="username-floating-icon" class="form-control" placeholder="Username" name="username" value="{{ @Auth::user()['username'] }}">
                                    <div class="form-control-position">
                                        <i class="feather icon-hash"></i>
                                    </div>
                                    <label for="username-floating-icon">Username</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="form-label-group position-relative has-icon-left">
                                    <input type="password" id="password-floating-icon" class="form-control" name="password" placeholder="Password">
                                    <div class="form-control-position">
                                        <i class="feather icon-lock"></i>
                                    </div>
                                    <label for="password-floating-icon">Password</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="form-label-group position-relative has-icon-left">
                                    <input type="password" id="confirm-password-floating-icon" class="form-control" name="confirm_password" placeholder="Confirm Password">
                                    <div class="form-control-position">
                                        <i class="feather icon-lock"></i>
                                    </div>
                                    <label for="confirm-password-floating-icon">Confirm Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-label-group position-relative has-icon-left">
                                    <input type="text" id="address_line_1" class="form-control" name="address_line_1" placeholder="Address Line 1" value="{{ @Auth::user()['address_line_1'] }}">
                                    <div class="form-control-position">
                                        <i class="feather icon-home"></i>
                                    </div>
                                    <label for="address_line_1">Address Line 1</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-label-group position-relative has-icon-left">
                                    <input type="text" id="address_line_2" class="form-control" name="address_line_2" placeholder="Address Line 2" value="{{ @Auth::user()['address_line_2'] }}">
                                    <div class="form-control-position">
                                        <i class="feather icon-home"></i>
                                    </div>
                                    <label for="address_line_2">Address Line 2</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-6">
                                <div class="form-label-group position-relative has-icon-left">
                                    <input type="text" id="city" class="form-control" name="city" placeholder="City" value="{{ @Auth::user()['city'] }}">
                                    <div class="form-control-position">
                                        <i class="feather icon-aperture"></i>
                                    </div>
                                    <label for="city">City</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-label-group position-relative has-icon-left">
                                    <input type="text" id="state" class="form-control" name="state" placeholder="State" value="{{ @Auth::user()['state'] }}">
                                    <div class="form-control-position">
                                        <i class="feather icon-map"></i>
                                    </div>
                                    <label for="state">State</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-label-group position-relative has-icon-left">
                                    <input type="text" id="postal_code" class="form-control" name="postal_code" placeholder="Postal Code" value="{{ @Auth::user()['postal_code'] }}">
                                    <div class="form-control-position">
                                        <i class="feather icon-map-pin"></i>
                                    </div>
                                    <label for="postal_code">Postal Code</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-label-group position-relative">
                                    <select id="country" name="country" class="form-control">
                                        <option value="Afghanistan">Afghanistan</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="American Samoa">American Samoa</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Virgin Islands">British Virgin Islands</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Cape Verde">Cape Verde</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="France">France</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guinea Conakry">Guinea Conakry</option>
                                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Laos">Laos</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Macedonia">Macedonia</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Moldova">Moldova</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Namibia">Namibia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherlands">Netherlands</option>
                                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palestine">Palestine</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Philippines">Philippines</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russia">Russia</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="Saint Kitts And Nevis">Saint Kitts And Nevis</option>
                                        <option value="Saint Lucia">Saint Lucia</option>
                                        <option value="Saint Vincent And The Grenadines">Saint Vincent And The Grenadines</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Sierra Leone">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="The Democratic Republic Of Congo">The Democratic Republic Of Congo</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turks And Caicos Islands">Turks And Caicos Islands</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                        <option value="Uruguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Somalia">Somalia</option>
                                    </select>
                                    <label for="country">Country</label>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Save <i class="fa fa-spinner fa-spin d-none"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="/js/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        $("button#dpz-single-file").dropzone({
            paramName: "avatar",
            url: '/profile/image/upload',
            params: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            maxFiles: 1,
            uploadMultiple: false,
            acceptedFiles: 'image/*',
            previewsContainer: ".dropzone-previews",
            createImageThumbnails: false,
            init: function () {
                this.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                this.on("addedfile",function () {
                    $('button#dpz-single-file i').toggleClass('d-none');
                })
                this.on("success",function (file,response) {
                    $('button#dpz-single-file i').toggleClass('d-none');
                    if (response.message){
                        toastr.success(response.message);
                    }
                    if (response.location){
                        window.location = response.location;
                    }
                });
                this.on("error",function (file,response) {
                    $('button#dpz-single-file i').toggleClass('d-none');
                    $.each(response, function (key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                toastr.error(value, 'Error');
                            });
                        }
                    });
                })
            }
        });
    </script>
@endpush
