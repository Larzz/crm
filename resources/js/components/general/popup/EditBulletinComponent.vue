<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Notes</h6><button type="button"
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
                        <textarea name="" id="" v-model="fields.message" cols="30" rows="1"
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
                required: false,
                type: Object
            },
            showPopup: {
                required: false,
                type: Boolean
            },
        },
        methods: {
            UpdateBulletin() {
                console.log(this.fields)
            },
            close() {
                $.emit('close', false)
            }
        }
    }

</script>

<style>

</style>
