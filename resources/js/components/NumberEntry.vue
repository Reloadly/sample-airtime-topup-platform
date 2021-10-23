<template>
    <tr>
        <td><span class="btn btn-xs round p-1 btn-primary">{{index+1}}</span> </td>
        <td>
            <select class="custom-select form-control required text-center" v-model="selectedCountry" required>
                <option v-for="country in countries" :value="country">{{ country.name }}</option>
            </select>
        </td>
        <td>
            <input type="number" v-model="number" class="form-control text-center">
        </td>
        <td>
            <select class="custom-select form-control required text-center" v-model="selectedOperator">
                <option v-for="operator in operators" :value="operator">{{ operator.name }}</option>
            </select>
        </td>
        <td>
            <input type="checkbox" class="form-control" v-model="isLocal" >
        </td>
        <td>
            <div v-if="selectedOperator && selectedOperator.supports_geographical_recharge_plans && selectedOperator.geographical_recharge_plans && selectedOperator.geographical_recharge_plans.length > 0">
                <select class="custom-select form-control required text-center" v-model="selectedZone">
                    <option v-for="zone in selectedOperator.geographical_recharge_plans" :value="zone">{{ zone.locationName }}</option>
                </select>
                <select v-if="selectedZone" class="custom-select form-control required text-center pt-1" v-model="amount">
                    <option v-for="amount in selectedZone.fixedAmounts" :value="amount">{{ amount }}</option>
                </select>
            </div>
            <div v-else >
                <select v-if="selectedOperator && selectedOperator.denomination_type === 'FIXED'" class="custom-select form-control required text-center" v-model="amount">
                    <option v-for="amount in (isLocal?selectedOperator.local_fixed_amounts:selectedOperator.fixed_amounts)" :value="amount">{{ amount }}</option>
                </select>
                <input v-else type="number" step="any" v-model="amount" class="form-control text-center">
            </div>
        </td>
        <td>
            <div class="badge badge-pill" v-bind:class="[valid===''?'badge-success':'badge-danger']">{{ valid===''? 'VALID':valid}}</div>
            <div>
                <input type="hidden" name="id[]" :value="model.id">
                <input type="hidden" name="country[]" :value="selectedCountry?selectedCountry.id:-1">
                <input type="hidden" name="operator[]" :value="selectedOperator?selectedOperator.id:-1">
                <input type="hidden" name="is_local[]" :value="isLocal?1:0">
                <input type="hidden" name="amount[]" :value="amount">
                <input type="hidden" name="number[]" :value="number">
            </div>
            <loading :active.sync="isLoading"
                     :can-cancel="false"
                     loader="dots"
                     :height="7"
                     :is-full-page="false"></loading>
        </td>
        <td>
            <button class="btn btn-sm btn-icon rounded-circle btn-outline-danger waves-effect waves-light" @click.prevent="deleteEntry">
                <i class="feather icon-x-circle"></i>
            </button>
        </td>
    </tr>
</template>

<style>
    tr td span.btn.btn-xs{
        font-size: 0.7rem;
        line-height: 0.5;
    }
    tr td{
        text-align: center !important;
    }
</style>

<script>
    import Loading from 'vue-loading-overlay';
    import VueSwal from 'vue-swal';
    export default {
        components: {
            Loading,
            VueSwal
        },
        props : ['model','countries', 'index', 'token'],
        data() {
            return {
                'number' : 'XXXXXXXXXXX',
                'selectedCountry' : {},
                'operators' : [],
                'amount' : 0.00,
                'isLocal' : false,
                'selectedOperator' : {},
                'valid' : 'LOADING',
                'isLoading' : false,
                'init' : false,
                'selectedZone' : null
            }
        },
        mounted() {
            if (this.model !== null && this.model !== '' && this.model !== undefined) {
                this.number = this.model.number;
                this.operators = this.model.operators;
                this.selectedCountry = this.model.country;
                this.selectedOperator = this.model.operator;
                this.amount = this.model.amount;
                this.isLocal = this.model.is_local === 1;
                this.updateValidity();
            }
        },
        methods: {
            deleteEntry: function(){
                this.$swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                        if (willDelete) {
                            axios.post("/topups/bulk/wizard/entry/delete/"+this.model.id).then(response => {
                                if (response.data.message)
                                    toastr.success(response.data.message);
                                window.dtView.row( ':eq('+this.index+')' ).remove().draw();
                                this.$emit('update',this.index);
                            });
                        }
                    })
            },
            updateValidity: function () {
                if (this.selectedCountry)
                    if (this.selectedOperator && this.selectedOperator.country_id === this.selectedCountry.id)
                        if (!(this.isLocal && !this.selectedOperator.supports_local_amounts))
                            switch (this.selectedOperator.denomination_type) {
                                case 'FIXED':
                                    var amounts = this.selectedOperator.fixed_amounts;
                                    if (this.isLocal)
                                        amounts = this.selectedOperator.local_fixed_amounts;
                                    var element = amounts.find(X => X === this.amount);
                                    if (element)
                                        this.valid = '';
                                    else
                                        this.valid = 'INVALID AMOUNT';
                                    break;
                                case 'RANGE':
                                    var min = this.selectedOperator.min_amount;
                                    var max = this.selectedOperator.max_amount
                                    if (this.isLocal){
                                        min = this.selectedOperator.local_min_amount;
                                        max = this.selectedOperator.local_max_amount;
                                    }
                                    if (this.amount >= min)
                                        if (this.amount <= max)
                                            this.valid = '';
                                        else
                                            this.valid = 'AMOUNT < ' + max;
                                    else
                                        this.valid = 'AMOUNT > ' + min;
                                    break;
                                default:
                                    this.valid = 'OPERATOR IT';
                            }
                        else
                            this.valid = 'OPERATOR DNSL';
                    else
                        this.valid = 'INVALID OPERATOR';
                else
                    this.valid = 'INVALID COUNTRY';
                if (window.dtView !== null && window.dtView !== '' && window.dtView !== undefined)
                    window.dtView.columns.adjust();
            }
        },
        watch: {
            'selectedCountry': function () {
                if (!this.init) {
                    this.init = true;
                    if (this.operators.length)
                        return ;
                }
                if (this.selectedCountry === null || this.selectedCountry === undefined) return this.updateValidity();
                this.isLoading = true;
                let token = this.token;
                let config = {
                    headers: {Authorization: `Bearer ${token}`},
                };
                axios.get("/api/countries/"+this.selectedCountry.id+"/operators", config).then(response => {
                    this.operators = response.data;
                    this.updateValidity();
                    this.isLoading = false;
                });
            },
            'selectedOperator': function () {
                if (this.selectedOperator === null || this.selectedOperator === undefined) return this.updateValidity();
                this.updateValidity();
            },
            'isLocal': function () {
                this.updateValidity();
            },
            'amount': function () {
                this.updateValidity();
            }
        }
    }
</script>
