<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Employee Creation</h6>
                    <button type="button" @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" v-model="fields.name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" v-model="fields.email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="text" v-model="fields.password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Position</label>
                                <input type="text" v-model="fields.position" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Date Joined</label>
                                <input type="date" v-model="fields.date_joined" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Birth Date</label>
                                <input type="date" v-model="fields.birth_date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Mobile Number</label>
                                <input type="text" v-model="fields.mobile_number" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="addEmployee()" class="btn btn-primary">Save changes</button>
                    <button type="button" @click.prevent="close" class="btn btn-link  ml-auto"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showClientPopup: false,
                fields: {
                    name: null,
                    email: null,
                    password: null,
                    position: null,
                    date_joined: null,
                    birth_date: null,
                    mobile_number: null
                }
            }
        },
        props: {
            showPopup: {
                required: true,
                type: Boolean
            }
        },
        methods: {
            close() {
               this.$emit('close', false)
            },
            addEmployee() {
            //    console.log(this.fields)

                 axios.get('/api/v1/employee')
                    .then(function (response) {
                        // handle success
                        console.log(response);
                        this.employees = response.data.result
                    })
                    .catch(function (error) {
                         this.$toastr.e(error);
                    })
                    .then(function () {
                        // always executed
                    });

            }
        }
    }

</script>

<style scoped>

    .form-group {
        margin-bottom: 13px;
    }

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }

    .slide-enter-active,
    .slide-leave-active {
        transition: transform .5s;
    }

    .slide-enter,
    .slide-leave-to {
        transform: translateY(-50%) translateX(100vw);
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 900;
        background-color: rgba(0, 0, 0, 0.3);
    }

    .modal {
        position: fixed;
        top: 10%;
        left: 27%;
        z-index: 1000;
        width: 100%;
        max-width: 50%;
        background-color: #FFF;
        border-radius: 16px;
        padding: 0px;
        display: block;
        height: 50%;
        min-height: 75%;
    }

    h1 {
        font-size: 24px;
        line-height: 1px;
    }

    .right {
        float: right;
    }


    .btn {
        font-size: .875rem;
        position: relative;
        transition: all .15s ease;
        letter-spacing: .025em;
        text-transform: none;
        will-change: transform;
    }

    .btn-primary {
        color: #fff;
        border-color: #f26f24;
        background-color: #f26f24;
        box-shadow: 0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%);
    }

</style>
