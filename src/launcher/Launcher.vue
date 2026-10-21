<script setup>
import { ref } from "vue";

import { loadState } from "@nextcloud/initial-state";

const appSource = loadState("overleafv6_nextcloud", "app_source");
const appOrigin = loadState("overleafv6_nextcloud", "app_origin");

const loading = ref(true);
</script>

<template>
  <div id="content" class="app-wrapper">
    <div id="app-loading" v-show="loading" class="app-wrapper-loading" style="color: black;">Loading application...</div>
    <iframe
        id="app-frame"
        v-show="!loading"
        class="app-frame"
        :class="{ 'app-loaded': !loading }"
        :src="appSource"
        title="Overleaf"
        :x-origin="appOrigin"
        @load="loading = false"
    ></iframe>
  </div>
</template>

<style lang="scss" scoped>
.app-wrapper {
    display: block;
    margin: 1rem 0 0 !important;
    border: none;
    width: 100%;
}

.app-wrapper-loading {
    text-align: center;
    vertical-align: middle;
    font-size: 120%;
    font-weight: bold;
    padding: 10px;
    background: #eee;
    border: #eee solid;
    border-radius: 5px;
    width: 100%;
    opacity: 60%;
}

.app-frame {
    width: 100%;
    margin-bottom: 20px;
}

iframe.app-loaded {
  background-color: white;
}
</style>
