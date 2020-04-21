<template>
    <div class='achievement'>
        <div class="badge_container">
            <img :src="require('../assets/badge.png')" class="badge">
        </div>

        <img :src="require('../assets/achievement.png')" class="icon">
        <div class="title_container">
            <div class="title">
                Прочитать первую главу
            </div>
        </div>
    </div>
</template>

<script>
import confetti from 'canvas-confetti';



export default {
    methods: {
        randomInRange: function(min, max) {
            return Math.random() * (max - min) + min;
        }
    },
    created() {
        confetti({ particleCount: 100 });
        setTimeout(() => {
            confetti({ angle: 45, particleCount: 50 });
        }, 1000);
        setTimeout(() => {
            confetti({ angle: 135, particleCount: 50 });
        }, 1600);
    }
}
</script>

<style lang="scss" scoped>
    .achievement {
        position: fixed;
        left: 50%;
        top: 50%;
    }

    @keyframes rotation {
        from { transform: rotate(0deg) }
        to { transform: rotate(360deg) }
    }

    @keyframes icon_appear {
        0% { opacity: 0 }
        80% { opacity: 0 }
        100% { opacity: 1 }
    }

    @keyframes badge_appear {
        0% {opacity: 0; transform: scale(0.3) }
        100% {opacity: 1; transform: scale(1) }
    }

    @keyframes title_appear {
        0% {opacity: 0; transform: scale(0.3) }
        90% {opacity: 0; transform: scale(0.3) }
        100% {opacity: 1; transform: scale(1) }
    }

    .badge_container {
        animation-name: badge_appear;
        animation-duration: 1s;
    }
    .badge {
        width: 256px;
        height: 256px;
        margin-left: -128px;
        margin-top: -128px;
        animation-duration: 20s;
        animation-name: rotation;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
        position: fixed;
        z-index: 100;
        //animation-direction: alternate;
    }
    .icon {
        width: 128px;
        height: 128px;
        margin-left: -64px;
        margin-top: -64px;
        position: fixed;
        z-index: 200;
        animation-duration: 3s;
        animation-name: icon_appear;

    }
    .title_container {
        position: fixed;
        z-index: 300;
        margin-top: 79px;

        .title {
            margin-left:-50%;
            background-color: #525252;
            padding: 10px 20px;
            border-radius: 22px;
            color: white;
            font-weight: bold;
            font-size: 20px;
            display: inline-block;
            animation-name: title_appear;
            animation-duration: 4s;

        }
    }
</style>
