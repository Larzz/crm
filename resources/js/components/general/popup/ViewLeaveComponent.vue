<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">View Leave</h6>
                    <button type="button" @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <hr>
                <div class="modal-body">
                    <div class="row">
                      <div class="form-group" style="margin-left: 29px">
                          <label for="">Employee: {{ sickLeave.name }}</label> <br>
                          <label for="">Number of days: {{ sickLeave.number_of_days }}</label> <br>
                          <template v-if="sickLeave.number_of_days==1">
                             <label for="">Date: {{ formatDate(sickLeave.leave_from)  }}</label>
                          </template>
                          <template v-else>
                             <label for="">Date: {{ formatDate(sickLeave.leave_from)  }} to {{ formatDate(sickLeave.leave_to)  }}</label>
                          </template>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click.prevent="close()" class="btn btn-link  ml-auto"
                            data-dismiss="modal">Close</button>
                    </div>
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
                    employee_id: null,
                    date_from: null,
                    date_to: null,
                    notes: null,
                    number_of_days: null
                },
                employees: []
            }
        },
        props: {
            showPopup: {
                required: true,
                type: Boolean
            },
            sickLeave: {
                required: false,
                type: Object
            },
        },
        mounted() {
        },
        methods: {
            beforeCreate() {
                JsLoadingOverlay.show(this.$configs);
            },
            created() {
                JsLoadingOverlay.hide();
            },
            close() {
                this.$emit('close', false)
            },
              formatDate(date) {
                const currentDate = new Date(date);
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                return currentDate.toLocaleDateString('en-us', options)
            },
            
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

    .modal-body {
        padding: 9px;
    }

    .modal-footer {
        display: flex;
        padding: 10px;
        border-top: 0 solid #e9ecef;
        border-bottom-right-radius: 0.4375rem;
        border-bottom-left-radius: 0.4375rem;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
    }

    .modal {
        position: fixed;
        top: 2%;
        left: 27%;
        z-index: 1000;
        width: 100%;
        max-width: 50%;
        background-color: #FFF;
        border-radius: 16px;
        padding: 0px;
        display: block;
        height: max-content;
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


    hr {
        margin-top: 0rem;
        margin-bottom: 0rem;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, .1);
    }

</style>
