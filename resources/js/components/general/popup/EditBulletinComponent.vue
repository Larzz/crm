<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Update Bulletin</h6><button type="button"
                        @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <!-- Chart -->
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" v-model="fields.title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Message</label>
                        <textarea name="" id="" v-model="fields.message" cols="30" rows="3"
                            class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Active</label>
                        <select name="" id="" v-model="fields.active" class="form-control">
                            <option value="Yes" class="form-control">Yes</option>
                            <option value="No" class="form-control">No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" @click="UpdateBulletin()" class="btn btn-primary">Save
                        changes</button><button type="button" @click.prevent="close()" class="btn btn-link  ml-auto"
                        data-dismiss="modal">Close</button></div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fields: {
                    id: null,
                    title: null,
                    message: null,
                    active: null
                }
            }
        },
        props: {
            bulletin: {
                required: true,
                type: Object
            },
            showPopup: {
                required: true,
                type: Boolean
            },
        },
        mounted() {
            this.fields.id = this.bulletin.id
            this.fields.title = this.bulletin.title
            this.fields.message = this.bulletin.message
            this.fields.active = this.bulletin.active
        },
        watch: {
            bulletin() {
                this.fields.id = this.bulletin.id
                this.fields.title = this.fields.title
                this.fields.message = this.fields.message
                this.fields.active = this.fields.active
            }
        },
        methods: {
            UpdateBulletin() {
                console.log(this.fields)
            },
            close() {
                this.$emit('close', this.fields)
                this.fields.id = null
                this.fields.title = null
                this.fields.message = null
                this.fields.active = null
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

</style>
