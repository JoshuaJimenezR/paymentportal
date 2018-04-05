@extends('portal')

@section('content')
    <form action="/payment/create" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="creditCardNumber">Card Number</label>
                    <input type="number"
                           class="form-control"
                           name="creditCardNumber"
                           id="creditCardNumber"
                           value="4485002500885704"
                           placeholder="Card Number"
                           required />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="creditCardHolderName">Name On Card</label>
                    <input type="text"
                           class="form-control"
                           id="creditCardHolderName"
                           name="creditCardHolderName"
                           value="Daria Knox"
                           placeholder="Card Holder's Name"
                           required />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label>Expiration Date</label>
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <select class="form-control" id="creditCardExpiryMonth" name="creditCardExpiryMonth" required>
                                <option value="" disabled selected>Month</option>
                                <option value="01">Jan</option>
                                <option value="02">Feb</option>
                                <option value="03">Mar</option>
                                <option value="04">Apr</option>
                                <option value="05">May</option>
                                <option value="06">Jun</option>
                                <option value="07" selected>Jul</option>
                                <option value="08">Aug</option>
                                <option value="09">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <select class="form-control" id="creditCardExpiryYear" name="creditCardExpiryYear" required>
                                <option value="" disabled selected>Year</option>
                                <option value="16">2016</option>
                                <option value="17">2017</option>
                                <option value="18">2018</option>
                                <option value="19">2019</option>
                                <option value="20" selected>2020</option>
                                <option value="21">2021</option>
                                <option value="22">2022</option>
                                <option value="23">2023</option>
                                <option value="24">2024</option>
                                <option value="25">2025</option>
                                <option value="26">2026</option>
                                <option value="27">2027</option>
                                <option value="28">2028</option>
                                <option value="29">2029</option>
                                <option value="30">2030</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="creditCardAmount">Amount (in dollars)</label>
                    <div class="input-group">
                        <div class="input-group-addon">$</div>
                        <input type="number"
                               class="form-control"
                               id="creditCardAmount"
                               name="creditCardAmount"
                               value="849"
                               placeholder="Amount code"
                               equired/>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="creditCardCVV">CVV</label>
                    <input type="text"
                           class="form-control"
                           id="creditCardCVV"
                           name="creditCardCVV"
                           value="849"
                           placeholder="CVV code"
                           equired/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="creditCountry">Country</label>
                    <select class="form-control"
                            name="creditCountry"
                            id="creditCountry"
                            required></select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="creditAddress">Billing Address</label>
                    <textarea type="text"
                              class="form-control"
                              name="creditAddress"
                              placeholder="Your Address"
                              required>4688 Andy Street</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="creditCity">City</label>
                    <input type="text"
                           class="form-control"
                           id="creditCity"
                           name="creditCity"
                           value="Rapid City"
                           placeholder="City"
                           required/>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="creditState">State</label>
                    <input type='text' id='creditState' class='form-control' name='creditState' placeholder='State' required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="creditZipCode">Zip Code/PostCode</label>
                    <input type="text"
                           id='creditZipCode'
                           class="form-control"
                           name='creditZipCode'
                           value="57701"
                           placeholder="Zip code"
                           required/>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="creditContactNumber">Contact Number</label>
                    <input type="text"
                           class="form-control"
                           id="creditContactNumber"
                           name="creditContactNumber"
                           value="605-399-2753"
                           placeholder="Phone"
                           required/>
                </div>
            </div>
        </div>
        <div class="row" style="display:none;">
            <div class="col-sm-12">
                <p class="payment-errors"></p>
            </div>
        </div>
        <button class="btn btn-primary btn-block" type="submit">
            Pay Now
        </button>
        <br>
    </form>
@endsection

@section('scripts')
    <script>
        function getCountries() {
            if ($('#creditCountry').has('option').length == 0) {
                $.getJSON('/json/country.json', function(data) {
                    var items = '<option value="" disabled selected>Choose a Country</option>';
                    $.each(data, function(index, value) {
                        if(index == '') {
                            items += "<option value='' disabled>" + value + "</option>";
                        } else{
                            items += "<option value='" + index + "'>" + value + "</option>";
                        }
                    });
                    $("#creditCountry").html(items);
                });
            }
        }

        function getStates(state) {
            $.getJSON('/json/states/'+state+'.json', function(data) {
                var items = '<option value="" disabled selected>Choose a State</option>';
                $.each(data, function(index, value) {
                    if(index == '') {
                        items += "<option value='' disabled>" + value + "</option>";
                    } else{
                        items += "<option value='" + index + "'>" + value + "</option>";
                    }
                });

                $("#creditState").html(items);

            });
        }

        $(document).ready(function () {
            getCountries();

            $("#creditCountry").change(function() {
                $("#creditState").replaceWith("<select class='form-control' name='creditState' id='creditState' required></select>");
                if($(this).val() == 'CA') {
                    getStates ('ca');
                } else if($(this).val() == 'GB') {
                    getStates ('gb');

                } else if($(this).val() == 'US') {
                    getStates ('us');
                } else {
                    $("#creditState").replaceWith("<input type='text' id='creditState' class='form-control' name='creditState' placeholder='State' required/>");
                }
            });



        });
    </script>
@endsection