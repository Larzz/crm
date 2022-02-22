<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <client-widget :user="user"> </client-widget>
            </div>
            <div class="col-md-4">
                <document-widget :user="user"></document-widget>
            </div>
            <div class="col-md-4">
                <notes :user="user" :role="auth.role"> </notes>
            </div>

            <div class="col-md-6">
                <presentation-widget :user="user"> </presentation-widget>
            </div>
            <div class="col-md-6">
                <meeting-widget :user="user"></meeting-widget>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
            }
        },
        props: ['user', 'auth'],
        mounted() {
            console.log(this.auth)
        }
    }

</script>

<style>

</style>
