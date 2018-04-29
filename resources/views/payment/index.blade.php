@extends('layouts.portal')

@section('content')
    <div class="col-md-12">
        <form action="/payment/create" method="post" id="makePayment">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group{{ $errors->has('creditCardNumber') ? ' has-error' : '' }}">
                        <label for="creditCardNumber">Card Number</label>
                        <input type="number"
                               class="form-control"
                               name="creditCardNumber"
                               id="creditCardNumber"
                               placeholder="Card Number"
                               required
                                />

                        @if ($errors->has('creditCardNumber'))
                            <span class="help-block">
                                <strong>Card Number field is required.</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group{{ $errors->has('creditCardHolderName') ? ' has-error' : '' }}">
                        <label for="creditCardHolderName">Name On Card</label>
                        <input type="text"
                               class="form-control"
                               id="creditCardHolderName"
                               name="creditCardHolderName"
                               placeholder="Card Holder's Name"
                               required
                                />
                        @if ($errors->has('creditCardHolderName'))
                            <span class="help-block">
                                <strong>Card Holder Name field is required.</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label>Expiration Date</label>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group{{ $errors->has('creditCardExpiryMonth') ? ' has-error' : '' }}">
                                <select class="form-control" id="creditCardExpiryMonth" name="creditCardExpiryMonth" required>
                                    <option value="" disabled selected>Month</option>
                                    <option value="01">Jan</option>
                                    <option value="02">Feb</option>
                                    <option value="03">Mar</option>
                                    <option value="04">Apr</option>
                                    <option value="05">May</option>
                                    <option value="06">Jun</option>
                                    <option value="07">Jul</option>
                                    <option value="08">Aug</option>
                                    <option value="09">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                                @if ($errors->has('creditCardExpiryMonth'))
                                    <span class="help-block">
                                        <strong>Card Expiry Month field is required.</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group{{ $errors->has('creditCardExpiryYear') ? ' has-error' : '' }}">
                                <select class="form-control" id="creditCardExpiryYear" name="creditCardExpiryYear" required>
                                    <option value="" disabled selected>Year</option>
                                    <option value="16">2016</option>
                                    <option value="17">2017</option>
                                    <option value="18">2018</option>
                                    <option value="19">2019</option>
                                    <option value="20">2020</option>
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
                                @if ($errors->has('creditCardExpiryYear'))
                                    <span class="help-block">
                                        <strong>Card Expiry Year field is required.</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group{{ $errors->has('creditCardAmount') ? ' has-error' : '' }}">
                        <label for="creditCardAmount">Amount (in dollars)</label>
                        <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="number"
                                   class="form-control"
                                   id="creditCardAmount"
                                   name="creditCardAmount"
                                   placeholder="Amount code"
                                   required
                                    />
                        </div>
                        @if ($errors->has('creditCardAmount'))
                            <span class="help-block">
                                <strong>Amount field is required.</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-group{{ $errors->has('creditCardCVV') ? ' has-error' : '' }}">
                        <label for="creditCardCVV">CVV</label>
                        <input type="text"
                               class="form-control"
                               id="creditCardCVV"
                               name="creditCardCVV"
                               placeholder="CVV code"
                               required
                                />
                        @if ($errors->has('creditCardCVV'))
                            <span class="help-block">
                                <strong>Card CVV is required</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="form-group{{ $errors->has('orderDescription') ? ' has-error' : '' }}">
                        <label for="orderDescription">Transaction's Description</label>
                        <textarea type="text"
                                  class="form-control"
                                  name="orderDescription"
                                  style="resize: vertical"
                                  required></textarea>

                        @if ($errors->has('orderDescription'))
                            <span class="help-block">
                                <strong>Description is required</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <button class="btn btn-primary btn-block" type="submit">
                Pay Now
            </button>
            <br>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $("#makePayment").submit(function(e) {
                $('body').loadingModal({
                    text: 'Loading...'
                });
            });
        });
    </script>
@endsection