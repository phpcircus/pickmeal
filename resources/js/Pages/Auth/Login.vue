<template>
    <blank-layout>
        <div class="px-6 bg-teal-700 min-h-screen flex justify-center pt-32">
            <div class="w-full max-w-sm">
                <logo-on-light class="block mx-auto w-full max-w-xs fill-white" height="50" />
                <form class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden" @submit.prevent="submit">
                    <div class="px-10 py-12">
                        <h1 class="text-center font-bold text-3xl">Welcome Back!</h1>
                        <div class="mx-auto mt-6 w-24 border-b-2" />
                        <text-input v-model="form.email" :errors="getErrors('email')" class="mt-10" label="Email" type="email" autofocus autocapitalize="off" />
                        <text-input v-model="form.password" class="mt-6" label="Password" type="password" />
                        <label class="mt-6 select-none flex items-center" for="remember">
                            <input id="remember" v-model="form.remember" class="mr-1" type="checkbox">
                            <span class="text-sm">Remember Me</span>
                        </label>
                    </div>
                    <div class="px-10 py-4 bg-gray-100 border-t border-gray-200 flex justify-between items-center">
                        <inertia-link class="hover:underline" tabindex="-1" :href="route('password.request.form')">Forgot password?</inertia-link>
                        <loading-button :loading="sending" class="btn btn-blue" type="submit">Login</loading-button>
                    </div>
                </form>
            </div>
        </div>
    </blank-layout>
</template>

<script>
import TextInput from '@/Shared/TextInput';
import BlankLayout from '@/Shared/BlankLayout';
import LogoOnLight from '@/Shared/LogoOnLight';
import LoadingButton from '@/Shared/LoadingButton';

export default {
    components: {
        TextInput,
        LogoOnLight,
        BlankLayout,
        LoadingButton,
    },
    data () {
        return {
            sending: false,
            form: {
                email: null,
                password: null,
                remember: null,
            },
        }
    },
    mounted () {
        document.title = `Login | ${this.$page.app.name}`;
    },
    methods: {
        submit () {
            this.sending = true;
            this.$inertia.post(this.route('login.attempt'), {
                email: this.form.email,
                password: this.form.password,
                remember: this.form.remember,
            }).then(() => {
                this.sending = false;
            });
        },
    },
}
</script>
