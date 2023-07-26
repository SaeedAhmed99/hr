<template>
    <div class="row vh-100 align-items-center">
        <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-7 d-md-block d-sm-none d-none h-100" style="background: linear-gradient(90deg, #00d2ff 0%, #3a47d5 100%)">
            <div class="row align-items-center h-100">
                <div class="col-12">
                    <h1 class="text-center align-self-center text-white">CloudHRM</h1>
                </div>
            </div>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 align-self-center p-2">
            <div class="row justify-content-start">
                <div class="col-12 d-md-none d-sm-block">
                    <h1 class="text-center align-self-center">CloudHRM</h1>
                </div>
                <div class="col-12">
                    <form @submit.prevent="formSubmit">
                        <!-- Email -->
                        <div>
                            <label for="email" class=""> Email </label>
                            <input :class="{ 'is-invalid': validationErrors?.email }" class="form-control" id="email" type="email" v-model="email" autofocus autocomplete="username" />
                            <!-- Validation Errors -->
                            <div class="invalid-feedback">
                                <div v-for="(message, idx) in validationErrors?.email" :key="'email-'+idx">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="">
                            <label for="password" class=""> Password </label>
                            <input :class="{ 'is-invalid': validationErrors?.password }" class="form-control" id="password" type="password" v-model="password" autocomplete="current-password" />
                            <!-- Validation Errors -->
                            <div class="invalid-feedback">
                                <div v-for="(message, idx) in validationErrors?.password" :key="'password-'+idx">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                        <!-- Remember me -->
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                            <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
                        </div>
                        <!-- Buttons -->
                        <div class="flex items-center justify-end mt-4">
                            <button class="btn btn-primary" :class="{ 'opacity-25': processing }" :disabled="processing">Log in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useRouter } from 'vue-router';
import { useStore } from "vuex";

const store = useStore();
const route = useRouter();

const email = ref("");
const password = ref("");

const formSubmit = () => {
    store.dispatch("loginUser", {
        email: email.value,
        password: password.value,
    }).then(() => {
        route.push('/home');
    });
};

const validationErrors = computed(() => store.getters.getValidationErrors);
const processing = computed(() => store.getters.isProcssing);
</script>
