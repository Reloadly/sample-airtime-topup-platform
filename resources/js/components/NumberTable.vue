<template>
    <div class="table-responsive">
        <form method="POST">
            <table class="table data-list-view w-100">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Country</th>
                    <th>Number</th>
                    <th>Operator</th>
                    <th>Local?</th>
                    <th>Amount</th>
                    <th>State</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <number-entry v-for="(number, index) in numbers" v-bind:key="number.id" v-bind:token="token" :model="number" :countries.sync="countries" :index.sync="index" @update="updateNumbers"></number-entry>
                </tbody>
            </table>
            <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-primary">Next</button>
            </div>
        </form>
    </div>
</template>

<style>
    tbody tr.odd,tbody tr.even{
        position: relative;
    }
    table.table thead tr th{
        text-align: center !important;
    }
</style>

<script>
    export default {
        props: ['dataNumbers','dataCountries', 'dataFileId', 'token'],
        data() {
            return {
                'numbers' : [],
                'countries' : []
            }
        },
        mounted() {
            if (this.dataNumbers !== null && this.dataNumbers !== '' && this.dataNumbers !== undefined)
                this.numbers = JSON.parse(this.dataNumbers);
            if (this.dataCountries !== null && this.dataCountries !== '' && this.dataCountries !== undefined)
                this.countries = JSON.parse(this.dataCountries);
            //console.log(this.numbers);
        },
        methods: {
            updateNumbers: function (index) {
                this.numbers.splice(index,1);
            }
        }
    }
</script>
