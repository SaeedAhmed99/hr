<template>
    <div class="wrapper" :class="{loggedIn: isAuthenticated}">
        <slot></slot>
    </div>
</template>

<script setup>
import { useStore } from 'vuex'
import { computed } from 'vue'
const store = useStore();
// access a state in computed function
const isAuthenticated = computed(() => store.getters.isAuthenticated)
</script>

<style scoped>
.wrapper{
    min-height: 100vh;
}

.loggedIn{
    padding-top: 64px;
    margin-left: 250px;
}

@media screen and (max-width: 991px)
{ 
    .wrapper{
        margin-left: 0px;
    }
}
</style>