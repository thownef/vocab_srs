<template>
  <div class="loading-mask">
    <div class="loading-mask__center">
      <div class="loading-mask__center-absolute">
        <div class="loading-mask__object loading-mask__object--one"></div>
        <div class="loading-mask__object loading-mask__object--two"></div>
        <div class="loading-mask__object loading-mask__object--three"></div>
        <div class="loading-mask__object loading-mask__object--four"></div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts"></script>

<style scoped>
.loading-mask {
  --spinner-loading-color: #248bd9;
  background-color: #ffffff;
  height: 100%;
  width: 100%;
  position: fixed;
  z-index: 9999;
  margin-top: 0;
  top: 0;
}

.loading-mask__center {
  width: 100%;
  height: 100%;
  position: relative;
}

.loading-mask__center-absolute {
  position: absolute;
  left: 50%;
  top: 50%;
  height: 60px;
  width: 60px;
  margin-top: -30px;
  margin-left: -30px;
  -webkit-animation: loading-center-absolute 1s infinite;
  animation: loading-center-absolute 1s infinite;
}

.loading-mask__object {
  width: 20px;
  height: 20px;
  background-color: var(--spinner-loading-color);
  opacity: 0.5;
  float: left;
  -moz-border-radius: 50% 50% 50% 50%;
  -webkit-border-radius: 50% 50% 50% 50%;
  border-radius: 50% 50% 50% 50%;
  margin-right: 20px;
  margin-bottom: 20px;
}

.loading-mask__object:nth-child(2n + 0) {
  margin-right: 0;
}

.loading-mask__object--one {
  -webkit-animation: object_one 1s infinite;
  animation: object_one 1s infinite;
}

.loading-mask__object--two {
  -webkit-animation: object_two 1s infinite;
  animation: object_two 1s infinite;
}

.loading-mask__object--three {
  -webkit-animation: object_three 1s infinite;
  animation: object_three 1s infinite;
}

.loading-mask__object--four {
  -webkit-animation: object_four 1s infinite;
  animation: object_four 1s infinite;
}

@-webkit-keyframes loading-center-absolute {
  100% {
    -ms-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes loading-center-absolute {
  100% {
    -ms-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@-webkit-keyframes object_one {
  50% {
    -ms-transform: translate(20px, 20px);
    -webkit-transform: translate(20px, 20px);
    transform: translate(20px, 20px);
  }
}

@keyframes object_one {
  50% {
    -ms-transform: translate(20px, 20px);
    -webkit-transform: translate(20px, 20px);
    transform: translate(20px, 20px);
  }
}

@-webkit-keyframes object_two {
  50% {
    -ms-transform: translate(-20px, 20px);
    -webkit-transform: translate(-20px, 20px);
    transform: translate(-20px, 20px);
  }
}

@keyframes object_two {
  50% {
    -ms-transform: translate(-20px, 20px);
    -webkit-transform: translate(-20px, 20px);
    transform: translate(-20px, 20px);
  }
}

@-webkit-keyframes object_three {
  50% {
    -ms-transform: translate(20px, -20px);
    -webkit-transform: translate(20px, -20px);
    transform: translate(20px, -20px);
  }
}

@keyframes object_three {
  50% {
    -ms-transform: translate(20px, -20px);
    -webkit-transform: translate(20px, -20px);
    transform: translate(20px, -20px);
  }
}

@-webkit-keyframes object_four {
  50% {
    -ms-transform: translate(-20px, -20px);
    -webkit-transform: translate(-20px, -20px);
    transform: translate(-20px, -20px);
  }
}

@keyframes object_four {
  50% {
    -ms-transform: translate(-20px, -20px);
    -webkit-transform: translate(-20px, -20px);
    transform: translate(-20px, -20px);
  }
}
</style>
