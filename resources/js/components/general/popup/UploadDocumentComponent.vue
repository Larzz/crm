<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Upload document</h6>
                    <button type="button" @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <select name="" id="" class="form-control">
                            <option value="">Driver License</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="example-drag">
                            <div class="upload">
                                <ul v-if="files.length">
                                    <li v-for="file in files" :key="file.id">
                                        <span>{{file.name}}</span> -
                                        <span>{{$formatSize(file.size)}}</span> -
                                        <span v-if="file.error">{{file.error}}</span>
                                        <span v-else-if="file.success">success</span>
                                        <span v-else-if="file.active">active</span>
                                        <span v-else></span>
                                    </li>
                                </ul>
                                <ul v-else>
                                    <td colspan="7">
                                        <div class="text-center p-5">
                                            <h4>Drop files anywhere to upload<br />or</h4>
                                            <label for="file" class="btn btn-lg btn-primary">Select Files</label>
                                        </div>
                                    </td>
                                </ul>

                                <div v-show="$refs.upload && $refs.upload.dropActive" class="drop-active">
                                    <h3>Drop files to upload</h3>
                                </div>
<!-- 
                                <div class="example-btn">
                                    <file-upload class="btn btn-primary" post-action="/upload/post" :multiple="true"
                                        :drop="true" :drop-directory="true" v-model="files" ref="upload">
                                        <i class="fa fa-plus"></i>
                                        Select files
                                    </file-upload>
                                    <button type="button" class="btn btn-success"
                                        v-if="!$refs.upload || !$refs.upload.active"
                                        @click.prevent="$refs.upload.active = true">
                                        <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                        Start Upload
                                    </button>
                                    <button type="button" class="btn btn-danger" v-else
                                        @click.prevent="$refs.upload.active = false">
                                        <i class="fa fa-stop" aria-hidden="true"></i>
                                        Stop Upload
                                    </button>
                                </div> -->
                            </div>

                            <div class="pt-5 source-code">
                                Source code: <a
                                    href="https://github.com/lian-yue/vue-upload-component/blob/master/docs/views/examples/Drag.vue">/docs/views/examples/Drag.vue</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" @click.prevent="close" class="btn btn-link  ml-auto"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import FileUpload from 'vue-upload-component'

    export default {
        components: {
            FileUpload,
        },
        data() {
            return {
                showClientPopup: false,
                files: [],
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
            }
        }
    }

</script>

<style scoped>
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
        padding: 25px;
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
