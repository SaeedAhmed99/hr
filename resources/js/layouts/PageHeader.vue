<template>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="page-header-title">
                        <h4 class="m-b-10">
                            {{ title }}
                        </h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="https://hrpayroll.codecloudtech.com/home">Home</a>
                        </li>
                        <li class="breadcrumb-item">Settings</li>
                    </ul>
                </div>
                <div class="col-sm-auto col-md">
                    <div class="float-end"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    title: String,
    breadcrumb: String,
});
</script>