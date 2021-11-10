<template xmlns="http://www.w3.org/1999/html">
    <div class="row justify-content-center">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 loader="dots"
                 :height="7"
                 :is-full-page="false"></loading>
        <div class="col-lg-6 col-md-8 col-12 my-2" v-if="biller">
            <div class="card">
                <div class="card-header">
                    <div class="w-100 justify-content-center text-center">
                        <div class="col-auto mt-3">
                            <img class="round-image" :src="biller.logo_urls[0]">
                        </div>
                    </div>
                    <div class="w-100 text-center mt-1">
                        <h3 class="col-12">{{ biller.title }}</h3>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form form-horizontal">
                            <div class="form-body">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="form-group row justify-content-center align-items-center">
                                            <div class="col-4">
                                                <p class="m-0">Email</p>
                                            </div>
                                            <div class="col-8">
                                                <div class="position-relative has-icon-left input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="feather icon-user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" v-model="email" placeholder="Enter Email">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" v-if="biller.fixed_recipient_denominations">
                                        <div class="form-group row mb-0 align-items-center justify-content-center">
                                            <div class="col-4">
                                                <p class="m-0">Gift Card</p>
                                            </div>
                                            <div class="col-8">
                                                <fieldset class="form-group">
                                                    <select class="form-control" id="basicSelect" v-model="selectedPaymentIndex">
                                                        <option v-for="(payment,index) in biller.fixed_recipient_denominations" :value="index">{{ biller.recipient_currency_code+' '+payment }}</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row justify-content-center align-items-center">
                                            <div class="col-4">
                                                <p class="m-0">Bill Amount</p>
                                            </div>
                                            <div class="col-8">
                                                <div class="position-relative has-icon-left">
                                                    <p>{{biller.sender_currency_code +' '+ (((amount+biller.sender_fee)*(1+(customerRate/100)))*(1-(typeof biller.pivot.discount !== 'undefined'? biller.pivot.discount/100 : 0))).toFixed(2)}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-primary waves-effect waves-light" @click="createInvoice">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .round-image{
        height: 60px;
        border-radius: 50%;
        width: 60px;
        object-fit: cover;
    }
</style>

<script>
import Loading from 'vue-loading-overlay';
export default {
    props: ['_gift_card','_token','_customer_rate'],
    data() {
        return {
            isLoading: true,
            email:null,
            biller:null,
            selectedPaymentIndex: 0,
            amount:0.00,
            invoice_id:-1,
            customerRate: 0
        }
    },
    mounted() {
        this.biller = JSON.parse(this._gift_card);
        this.customerRate = parseFloat(this._customer_rate);
        this.amount = this.biller.fixed_sender_denominations[0];
    },
    created() {
        this.isLoading = false;
    },
    watch: {
        selectedPaymentIndex:function () {
            this.amount = this.biller.fixed_sender_denominations[this.selectedPaymentIndex];
        },
    },
    components: {
        Loading
    },
    methods: {
        createInvoice:function () {
            if (this.validateEmail(this.email) === true){
                let config = {
                    headers: {Authorization: `Bearer ${this._token}`},
                };
                let data = {
                    'payment_index' : this.selectedPaymentIndex,
                    'email': this.email,
                    'gift_id':this.biller.id,
                    'amount': this.amount
                };
                axios.post('/api/gift_cards/receipt',data,config)
                    .then(response => {
                        if (response.data.invoice_id){
                            toastr.success(response.data.message);
                            window.location.href = '/invoices/view/'+response.data.invoice_id;
                            this.isLoading = true;
                        }
                        if (response.data.message)
                            toastr.success(response.data.message);
                        if (response.data.location)
                            window.location.href = response.data.location;
                    }).catch(error => {
                    let errors = error.response.data.errors;
                    if (errors)
                        for (let e in errors)
                            if (errors[e])
                                toastr.error(errors[e]);
                            else
                                toastr.error('Server Error, Please contact admin');
                });
            }else{
                toastr.error('Please Provide Valid  Email');
            }
        },
        validateEmail:function(email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
    },
}
</script>
