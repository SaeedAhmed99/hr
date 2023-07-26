<template>
    <BaseTopbar v-if="isAuthenticated" />
    <BaseSidebar v-if="isAuthenticated" />
    <BaseWrapper>
        <router-view></router-view>
    </BaseWrapper>
</template>

<script setup>
import BaseWrapper from "./layouts/BaseWrapper.vue";
import BaseSidebar from "./layouts/BaseSidebar.vue";
import BaseTopbar from "./layouts/BaseTopbar.vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { computed, onMounted } from "vue";

const store = useStore();
const router = useRouter();
// access a state in computed function
const isAuthenticated = computed(() => store.getters.isAuthenticated);

onMounted(() => {
    store.dispatch("getUser");
});
</script>