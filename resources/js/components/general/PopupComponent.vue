<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showClientPopup" @click="showClientPopup = false"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showClientPopup">
                <slot></slot>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showClientPopup: false
            }
        },
        props: ['showPopup'],
        methods: {
             OpenClientPopup: function($event) {
                 this.showClientPopup = true
              }
        }
    }

</script>

<style lang="scss" scoped>

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
        position: absolute;
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

</style>
