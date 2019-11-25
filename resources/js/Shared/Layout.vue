<template>
    <div class="flex flex-col min-h-screen">
        <modal />
        <flash-message />

        <!-- TOP BARS -->
        <div class="fixed top-0 w-full"
             style="z-index:80"
        >
            <!-- TOP WHITE BAR -->
            <div class="flex justify-between items-center w-full px-4 py-6 bg-white">
                <inertia-link class="mt-1"
                              :href="route('home')"
                >
                    <logo-on-light position="left" />
                </inertia-link>
                <div class="hidden md:block">
                    <main-menu display="flex flex-row" />
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-grow w-full relative">
            <div class="px-4 py-8 lg:py-12 w-full">
                <breadcrumbs />
                <slot />
            </div>
        </div>

        <!-- Site Footer -->
        <site-footer class="self-end" />
    </div>
</template>

<script>
import Modal from '@/Shared/Modal';
import User from '@/Shared/Icons/User';
import IconBase from '@/Shared/IconBase';
import MainMenu from '@/Shared/MainMenu';
import UserMenu from '@/Shared/UserMenu';
import Dropdown from '@/Shared/Dropdown';
import LogoOnLight from '@/Shared/LogoOnLight';
import SiteFooter from '@/Shared/SiteFooter';
import Breadcrumbs from '@/Shared/Breadcrumbs';
import FlashMessage from '@/Shared/FlashMessage';
import LockClosed from '@/Shared/Icons/LockClosed';
import CheveronDown from '@/Shared/Icons/CheveronDown';

export default {
    components: {
        User,
        Modal,
        IconBase,
        UserMenu,
        MainMenu,
        Dropdown,
        LogoOnLight,
        SiteFooter,
        LockClosed,
        Breadcrumbs,
        FlashMessage,
        CheveronDown,
    },
    props: {
        title: String,
    },
    head: {
        title: function () {
            return {
                inner: this.title,
            }
        },
    },
}
</script>
