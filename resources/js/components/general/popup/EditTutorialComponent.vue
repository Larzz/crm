<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Upload Meeting Minutes</h6>
                    <button type="button" @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                        <!-- Chart -->
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" v-model="fields.title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Message</label>
                            <vue-editor v-model="fields.content"> </vue-editor>
                        </div>
                        <!-- <button href="#!" @click="submit()" class="btn btn-primary">Add</button> -->
                </div>
                <div class="modal-footer">
                    <button type="button" @click="saveTutorial" class="btn btn-primary">Save changes</button>
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
                files: [],
                types: [],
                fields: {
                    id: null,
                    name: null,
                    content: null,
                },
                api_token: window.Laravel.api_token,
            }
        },
        props: {
            showPopup: {
                required: true,
                type: Boolean
            },
            time: {
                required: true,
                type: Number
            },
            tutorial: {
                required: false,
                type: Object
            }
        },
        watch: {
            time() {
                // console.log(this.tutorial)
                this.fields.id = this.tutorial.id
                this.fields.title = this.tutorial.title
                this.fields.content = this.tutorial.content
            }
        },
        mounted() {},
        methods: {
            close() {
                this.$emit('close', this.fields)
            },
            saveTutorial() {
                console.log(this.tutorial)

                
                let $this = this

                if (!this.fields.title) {
                    $this.$toastr.e('Title is Required')
                    return;
                }

                if (!this.fields.content) {
                    $this.$toastr.e('Content is Required')
                    return;
                }

                axios({
                        method: 'patch',
                        url: `/api/v1/tutorials/${this.fields.id}?api_token=${window.Laravel.api_token}`,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('Succesfully Update new Tutorial')
                            $this.fields.title = null
                            $this.fields.content = null
                            $this.close()
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});

            }
        }
    }

</script>

<style scoped>
    .customdropzone {
        width: 100%;
    }

    .form-group {
        margin-bottom: 10px;
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
        top: 4%;
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

</style>
