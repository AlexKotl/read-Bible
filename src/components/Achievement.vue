<template>
  <div class="achievement">
    <div class="background"></div>

    <div class="badge_container">
      <!-- <img :src="require('../assets/cloud.png')" class="cloud" alt=""> -->
      <!-- <img :src="require('../assets/badge.png')" class="badge"> -->
    </div>

    <div class="icons-container">
      <img :src="icon_image" class="icon" />
      <img :src="icon_done_image" class="icon-done" />
    </div>

    <div class="title_container">
      <div class="title">
        {{ title }}
      </div>
    </div>
  </div>
</template>

<script>
import confetti from "canvas-confetti";

export default {
  props: ["title", "icon"],
  methods: {
    randomInRange: function(min, max) {
      return Math.random() * (max - min) + min;
    },
  },
  computed: {
    icon_image: function() {
      try {
        return require("../assets/achievements/" + this.icon + ".png");
      } catch (e) {
        console.error("Cant find achievement icon. Using default");
        return require("../assets/achievements/default.png");
      }
    },
    icon_done_image: function() {
      try {
        return require("../assets/achievements/" + this.icon + "_done.png");
      } catch (e) {
        console.error("Cant find achievement done icon.", this.icon);
        return require("../assets/achievements/default.png");
      }
    },
  },
  created() {
    setTimeout(() => {
      confetti({ particleCount: 100 });
    }, 2000);
    setTimeout(() => {
      confetti({ angle: 45, particleCount: 50 });
    }, 2900);
    setTimeout(() => {
      confetti({ angle: 135, particleCount: 50 });
    }, 3500);
    setTimeout(() => {
      confetti({ gravity: 0.5, spread: 90, particleCount: 120 });
    }, 7000);
  },
};
</script>

<style scoped>
.achievement {
  position: fixed;
  left: 50%;
  top: 50%;
  z-index: 1000;
}

@keyframes rotation {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

@keyframes icon_appear {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

@keyframes icon_drop {
  0% {
    opacity: 0;
    transform: scale(10);
  }
  60% {
    opacity: 0;
    transform: scale(10);
  }
  90% {
    opacity: 1;
    transform: scale(1.3);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

@keyframes title_appear {
  0% {
    opacity: 0;
    transform: scale(0.3);
  }
  90% {
    opacity: 0;
    transform: scale(0.3);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

@keyframes shake {
  10%,
  90% {
    transform: translate(2px, -2px);
  }
  20%,
  80% {
    transform: translate(-3px, 2px);
  }
  30%,
  50%,
  70% {
    transform: translate(-1px, -2px);
  }
  40%,
  60% {
    transform: translate(1px, 1px);
  }
}

.background {
  position: fixed;
  z-index: 1;
  //background-color: white;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  // animation-duration: .2s;
  // animation-name: icon_appear;
}
.cloud {
  margin-left: -300px;
  margin-top: -300px;
  position: fixed;
  z-index: 100;
}
.badge {
  width: 600px;
  height: 600px;
  margin-left: -300px;
  margin-top: -300px;
  animation-duration: 20s;
  animation-name: rotation;
  animation-iteration-count: infinite;
  animation-timing-function: linear;
  position: fixed;
  z-index: 100;
}
.icon {
  width: 360px;
  height: 360px;
  margin-left: -180px;
  margin-top: -180px;
  position: fixed;
  z-index: 200;
  animation-duration: 0.5s;
  animation-name: icon_appear;
}
.icon-done {
  width: 360px;
  height: 360px;
  margin-left: -180px;
  margin-top: -180px;
  position: fixed;
  z-index: 210;
  animation-duration: 2s;
  animation-name: icon_drop;
  animation-timing-function: ease-out;
}
.icons-container {
  animation-duration: 0.7s;
  animation-delay: 1.9s;
  animation-name: shake;
}
.title_container {
  position: fixed;
  z-index: 300;
  margin-top: 170px;

  .title {
    margin-left: -50%;
    border: 3px solid #525252;
    background-color: white;
    padding: 10px 20px;
    border-radius: 22px;
    color: #333;
    font-weight: bold;
    font-size: 20px;
    display: inline-block;
    animation-name: title_appear;
    animation-duration: 4s;
  }
}
</style>
