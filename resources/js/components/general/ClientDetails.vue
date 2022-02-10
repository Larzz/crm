<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <client-widget :user="user"> </client-widget>
            </div>
            <div class="col-md-4">
                <presentation-widget :user="user"> </presentation-widget>
            </div>
            <div class="col-md-4">
                <meeting-widget :user="user"></meeting-widget>
            </div>
            <div class="col-md-6">
                <notes :user="user"> </notes>
            </div>
            <div class="col-md-6">
                <document-widget :user="user"></document-widget>
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
        props: ['user'],
        mounted() {
        }
    }

</script>

<style>

</style>
