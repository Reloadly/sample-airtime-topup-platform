<template xmlns="http://www.w3.org/1999/html">
    <div class="col-12 mt-5">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 loader="dots"
                 :height="7"
                 :is-full-page="false"></loading>
        <div class="row justify-content-center align-items-center">
            <div class="card col-6" v-if="Object.keys(countries).length">
                <div class="card-body row justify-content-center align-items-center">
                    <p class="col-auto m-0">Select Country</p>
                    <select class="col form-control" v-model="selectedCountry">
                        <option v-for="country in countries" :value="country">{{ country.name }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row justify-content-center" v-if="selectedCountry">
            <div class="col-12">
                <div class="row match-height justify-content-around">
                    <div class="col-md-5 col-sm-10 ml-sm-1" v-for="gift in selectedCountry.gifts">
                        <a v-bind:href="'/gift_cards/show/'+gift.id" class="text-dark">
                            <div class="card mouse-pointer">
                                <div class="card-content">
                                    <div class="row justify-content-between">
                                        <div class="col-4">
                                            <img v-if="gift.logo_urls[0] !== null" class="card-image img-fluid" :src="gift.logo_urls[0]" alt="Gift Card">
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body">
                                                <h5> {{ gift.title }} </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.mouse-pointer{
    cursor: pointer;
}
</style>

<script>
import Loading from 'vue-loading-overlay';
export default {
    props: ['_countries','_token','_customer_rate'],
    data() {
        return {
            isLoading: true,
            countries:{},
            selectedCountry:{},
            gifts:{},
            search:null,
            hide_image:false,
            allBillers:{},
            showCountry:false,
        }
    },
    mounted() {
        this.countries = JSON.parse(this._countries);
    },
    created() {
        window.setTimeout(()=>{
            this.isLoading = false;
        },500);
    },
    watch: {
        selectedCountry: function () {
            this.isLoading = true;
            axios.get('/gift_cards/countries/'+this.selectedCountry.id+"/products").then(response => {
                this.selectedCountry.gifts = response.data;
                this.isLoading = false;
            }).catch(error => {
                this.isLoading = false;
                let errors = error.response.data.errors;
                if (errors)
                    for (let e in errors)
                        if (errors[e])
                            toastr.error(errors[e]);
                        else
                            toastr.error('Server Error, Please contact admin');
            });
        }
    },
    components: {
        Loading
    },
    methods: {
        displayCountries:function (){
            this.showCountry = !this.showCountry;
        },
        selectCategory:function (index) {
            if (!(index in this.countries)) return;
            this.isLoading = true;
            setTimeout(()=>{
                this.selectedCountry = (this.countries)[index];
                if (this.selectedCountry.gifts && this.selectedCountry.gifts.length)
                    this.gifts = this.selectedCountry.gifts;
                else
                    this.gifts = {};
                this.isLoading = false
            },800);
        },
        displaySearchBar:function () {
            if (this.search) {
                let active_li = document.getElementsByClassName('active');
                if (active_li[1] && active_li[1].id)
                    active_li[1].classList.remove('active');
                this.hide_image = false;
                this.selectedCountry = {};
                this.gifts = {};
            }
        }
    },
}
</script>
