<template>
    <blank-layout>
        <div class="px-6 bg-green-700 min-h-screen flex justify-center pt-32">
            <div class="w-full max-w-sm">
                <logo-on-light class="block mx-auto w-full max-w-xs fill-white" height="50" />
                <div class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-10 pt-12 pb-4">
                        <h1 class="text-center font-bold text-3xl">Email Verification</h1>
                        <div class="mx-auto mt-6 w-24 border-b-2" />
                    </div>
                    <div class="px-10 py-4 bg-gray-100 border-t border-gray-200 flex flex-col justify-between items-center">
                        <span class="text-base text-gray-600 mb-8">
                            Before proceeding, please check your email for a verification link. If you did not receive the email, click
                            <inertia-link class="hover:underline text-green-500" tabindex="-1" :href="route('verification.resend')">here to resend the verification email?</inertia-link>
                        </span>
                        <span class="flex self-start text-sm text-gray-600 mb-4">
                            <inertia-link class="btn btn-text mr-auto" tabindex="-1" :href="route('dashboard')">Dashboard</inertia-link>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </blank-layout>
</template>

<script>
import LogoOnLight from '@/Shared/LogoOnLight';
import BlankLayout from '@/Shared/BlankLayout';

export default {
    components: { BlankLayout, Logo },
}
</script>
