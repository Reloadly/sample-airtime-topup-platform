<template>
    <div>
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 loader="dots"
                 :height="7"
                 :is-full-page="false"></loading>
        <div>
            <div class="row justify-content-center align-items-center py-1">
                <label class="col-auto" for="username">Search User</label>
                <div class="col-md-6">
                    <input type="text" id="username" class="form-control disabled" placeholder="Enter Username OR Phone OR Email" v-model="username" v-on:keyup="searchUserKeyUp">
                </div>
                <button @click="searchUser()" class="btn btn-sm btn-primary btn-icon"><i class="feather icon-search"></i></button>
            </div>
            <div v-if="user !== null" class="row justify-content-center align-items-center py-2">
                <div class="users-view-image">
                    <img :src="user.image" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                </div>
                <div class="col-auto">
                    <table>
                        <tbody><tr>
                            <td class="font-weight-bold">Username</td>
                            <td>{{ user.username }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Name</td>
                            <td>{{ user.name }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Email</td>
                            <td>{{ user.email }}</td>
                        </tr>
                        </tbody></table>
                </div>
            </div>
            <div class="row justify-content-center align-items-center pb-3" v-if="user !== null" >
                <label class="col-auto" for="text_amount">Enter Amount To Send</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" >{{ this.currency }}</span>
                        </div>
                        <input id="text_amount" type="number" step="any" min="0" :max="''" class="form-control required" v-model="amount">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center pb-3" v-if="user !== null" >
                <button @click="transferMoney()" class="btn btn-primary">Transfer Money</button>
            </div>
        </div>
    </div>
</template>

<style>
    .users-view-image {
        width: 150px;
        box-sizing: border-box;
    }
    table td {
        padding-bottom: .8rem;
        min-width: 140px;
        word-break: break-word;
    }
</style>

<script>
    import Loading from 'vue-loading-overlay';
    export default {
        props: ['currency'],
        data() {
            return {
                isLoading: false,
                username: "",
                user: null,
                amount: 0
            }
        },
        methods: {
            transferMoney: function(){
                if (this.amount <= 0)
                {
                    toastr.error('Enter Amount to Continue','Error');
                    return;
                }
                var $this = this;
                swal.fire({
                    title: 'Are you sure?',
                    text: "This cannot be undone.",
                    type: 'warning',
                    showCancelButton: 1,
                    confirmButtonText: 'Send Money',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: !0

                }).then(function (e) {
                    if (e.value) {
                        $this.isLoading = true;
                        axios
                            .post('transfer', {
                                '_token' : $('meta[name="csrf-token"]').attr('content'),
                                'user' : $this.user.id,
                                'amount' : $this.amount
                            })
                            .then(response => {
                                $this.isLoading = false;
                                if (response.data.message)
                                    toastr.success(response.data.message);
                                if (response.data.location)
                                    window.location = response.data.location;
                            }).catch(function (error) {
                                if (error.response) {
                                    $.each(error.response.data, function (key, value) {
                                        if ($.isPlainObject(value)) {
                                            $.each(value, function (key, value) {
                                                toastr.error(value, 'Error');
                                            });
                                        }
                                    });
                                }
                                $this.isLoading = false;
                            });

                    } else {
                        swal.fire({
                            title: 'Cancelled!',
                            text: "No Transfer Made.",
                            type: 'error',
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-brand'
                        })
                    }
                });
            },
            searchUserKeyUp: function(e){
                if (e.keyCode === 13) {
                    this.searchUser();
                }
            },
            searchUser: function(){
                if (this.username === "")
                {
                    toastr.error('Enter User To Continue','Error');
                    return;
                }
                this.isLoading = true;
                var $this = this;
                axios.get('/api/users/find/'+this.username)
                    .then(response => {
                        this.user = response.data;
                        $this.isLoading = false;
                    }).catch(function (error) {
                        if (error.response) {
                            $this.user = null;
                            $.each(error.response.data, function (key, value) {
                                if ($.isPlainObject(value)) {
                                    $.each(value, function (key, value) {
                                        toastr.error(value, 'Error');
                                    });
                                }
                            });
                        }
                        $this.isLoading = false;
                    });
            }
        },
        mounted(){
           // this.isLoading = true;

        },
        created() {

            this.isLoading = false;
        },
        watch: {

        },
        components: {
            Loading
        }
    }
</script>
